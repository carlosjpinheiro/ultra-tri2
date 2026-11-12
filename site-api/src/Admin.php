<?php
declare(strict_types=1);

function adminSession(): void
{
    $local = PHP_SAPI === 'cli-server' && in_array($_SERVER['REMOTE_ADDR'] ?? '', ['127.0.0.1', '::1'], true);
    ini_set('session.use_strict_mode', '1');
    ini_set('session.use_only_cookies', '1');
    ini_set('session.use_trans_sid', '0');
    session_name('ultra_site_admin');
    session_set_cookie_params(['lifetime' => 0, 'path' => '/site-api', 'secure' => !$local, 'httponly' => true, 'samesite' => 'Strict']);
    session_start();
    if (isset($_SESSION['last_seen']) && (time() - $_SESSION['last_seen'] > 3600 || time() - ($_SESSION['started'] ?? 0) > 43200)) {
        $_SESSION = [];
        session_regenerate_id(true);
    }
    $_SESSION['csrf'] ??= bin2hex(random_bytes(32));
    $_SESSION['started'] ??= time();
    $_SESSION['last_seen'] = time();
}

function adminCsrf(): void
{
    $token = $_SERVER['HTTP_X_CSRF_TOKEN'] ?? '';
    if (!is_string($token) || !hash_equals($_SESSION['csrf'], $token)) respond(403, ['message' => 'Sessão de segurança inválida. Atualize a página e tente novamente.']);
}

function adminUser(PDO $db): array
{
    if (empty($_SESSION['admin_id'])) respond(401, ['message' => 'Entre para acessar a administração.']);
    $query = $db->prepare('SELECT id, name, email, role, active FROM site_admin_users WHERE id = ?');
    $query->execute([$_SESSION['admin_id']]);
    $user = $query->fetch();
    if (!$user || !(bool) $user['active']) {
        $_SESSION = [];
        session_regenerate_id(true);
        respond(401, ['message' => 'Sua sessão expirou. Entre novamente.']);
    }
    if ($user['role'] !== 'admin') respond(403, ['message' => 'Você não tem permissão para acessar esta área.']);
    return ['id' => (int) $user['id'], 'name' => $user['name'], 'email' => $user['email']];
}

function adminLogin(PDO $db): never
{
    adminCsrf();
    if (strtolower(trim(explode(';', $_SERVER['CONTENT_TYPE'] ?? '')[0])) !== 'application/json') respond(415, ['message' => 'Envie os dados em JSON.']);
    $raw = file_get_contents('php://input', false, null, 0, 8193);
    if (strlen($raw) > 8192) respond(413, ['message' => 'Requisição muito grande.']);
    try { $input = json_decode($raw, true, 16, JSON_THROW_ON_ERROR); }
    catch (JsonException) { respond(400, ['message' => 'JSON inválido.']); }
    if (!is_array($input) || !is_string($input['email'] ?? null) || !is_string($input['password'] ?? null)) respond(400, ['message' => 'Informe e-mail e senha.']);
    $email = strtolower(trim($input['email']));
    $password = $input['password'];
    if (strlen($email) > 190 || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($password) > 72) respond(401, ['message' => 'E-mail ou senha inválidos.']);
    // Count every login attempt atomically, across workers and sessions.
    $bucket = intdiv(time(), 900);
    $db->exec('DELETE FROM site_admin_login_limits WHERE bucket < ' . ($bucket - 96));
    foreach (['ip:' . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') => 30, 'email:' . $email => 10] as $key => $limit) {
        $q = $db->prepare('INSERT INTO site_admin_login_limits (key_hash, bucket, attempts) VALUES (?, ?, LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE attempts = LAST_INSERT_ID(attempts + 1)');
        $q->execute([hash('sha256', $key), $bucket]);
        if ((int) $db->query('SELECT LAST_INSERT_ID()')->fetchColumn() > $limit) {
            header('Retry-After: ' . (900 - time() % 900));
            respond(429, ['message' => 'Muitas tentativas de login. Aguarde e tente novamente.']);
        }
    }
    $q = $db->prepare('SELECT id, password_hash, active, role FROM site_admin_users WHERE email = ?');
    $q->execute([$email]);
    $user = $q->fetch();
    $verified = password_verify($password, $user['password_hash'] ?? '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2uheWG/igi.');
    if (!$verified || !$user || !(bool) $user['active'] || $user['role'] !== 'admin') respond(401, ['message' => 'E-mail ou senha inválidos.']);
    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
        $q = $db->prepare('UPDATE site_admin_users SET password_hash = ? WHERE id = ?');
        $q->execute([password_hash($password, PASSWORD_DEFAULT), $user['id']]);
    }
    session_regenerate_id(true);
    $_SESSION = ['admin_id' => (int) $user['id'], 'csrf' => bin2hex(random_bytes(32)), 'last_seen' => time(), 'started' => time()];
    respond(200, ['user' => adminUser($db), 'csrf_token' => $_SESSION['csrf']]);
}

function adminRoutes(string $path, string $method): never
{
    try {
        adminSession();
        if ($path === '/site-api/v1/admin/session' && $method === 'GET') {
            $user = empty($_SESSION['admin_id']) ? null : adminUser(siteDatabase());
            respond(200, ['user' => $user, 'csrf_token' => $_SESSION['csrf']]);
        }
        if ($path === '/site-api/v1/admin/login' && $method === 'POST') adminLogin(siteDatabase());
        if ($path === '/site-api/v1/admin/logout' && $method === 'POST') {
            adminCsrf();
            $_SESSION = [];
            session_destroy();
            $params = session_get_cookie_params();
            unset($params['lifetime']);
            setcookie(session_name(), '', ['expires' => time() - 3600] + $params);
            respond(200, ['message' => 'Sessão encerrada.']);
        }
        // Authenticate and authorize before reading any registration or returning details.
        if (empty($_SESSION['admin_id'])) respond(401, ['message' => 'Entre para acessar a administração.']);
        $db = siteDatabase();
        adminUser($db);
        if ($path === '/site-api/v1/admin/staff' && $method === 'GET') {
            $page = max(1, min(1000000, (int) ($_GET['page'] ?? 1)));
            $search = $_GET['search'] ?? '';
            if (!is_string($search) || mb_strlen($search) > 180) respond(400, ['message' => 'Busca inválida.']);
            $search = trim($search);
            $where = $search === '' ? '' : ' WHERE name LIKE ? OR email LIKE ?';
            $params = $search === '' ? [] : ['%' . $search . '%', '%' . $search . '%'];
            $q = $db->prepare('SELECT COUNT(*) FROM staff_registrations' . $where);
            $q->execute($params);
            $total = (int) $q->fetchColumn();
            $page = min($page, max(1, (int) ceil($total / 20)));
            $q = $db->prepare('SELECT id, event_year, name, email, created_at, answers FROM staff_registrations' . $where . ' ORDER BY created_at DESC, id DESC LIMIT 20 OFFSET ' . (($page - 1) * 20));
            $q->execute($params);
            $rows = [];
            foreach ($q->fetchAll() as $row) {
                $answers = json_decode($row['answers'], true, 64, JSON_THROW_ON_ERROR);
                unset($row['answers']);
                $row['whatsapp'] = $answers['whatsapp'] ?? '';
                $row['city'] = $answers['cidadeEstado'] ?? '';
                $row['departments'] = $answers['departamentos'] ?? [];
                $rows[] = $row;
            }
            respond(200, ['items' => $rows, 'total' => $total, 'page' => $page, 'page_size' => 20]);
        }
        if ($method === 'GET' && preg_match('~^/site-api/v1/admin/staff/([1-9][0-9]*)$~D', $path, $match)) {
            $q = $db->prepare('SELECT id, event_year, name, email, birth_date, answers, created_at FROM staff_registrations WHERE id = ?');
            $q->execute([$match[1]]);
            $row = $q->fetch();
            if (!$row) respond(404, ['message' => 'Inscrição não encontrada.']);
            $row['answers'] = json_decode($row['answers'], true, 64, JSON_THROW_ON_ERROR);
            respond(200, ['registration' => $row]);
        }
        respond(404, ['message' => 'Rota não encontrada.']);
    } catch (Throwable $error) {
        error_log('Ultra Site admin failure: ' . get_class($error) . ' ' . $error->getCode());
        respond(503, ['message' => 'Administração temporariamente indisponível. Tente novamente mais tarde.']);
    }
}
