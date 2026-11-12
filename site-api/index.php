<?php
declare(strict_types=1);
require __DIR__ . '/src/Database.php';
require __DIR__ . '/src/Validation.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');
header('X-Content-Type-Options: nosniff');
function respond(int $status, array $body): never {
    http_response_code($status);
    echo json_encode($body, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR);
    exit;
}
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];
if (str_starts_with($path, '/site-api/v1/admin/')) {
    require __DIR__ . '/src/Admin.php';
    adminRoutes($path, $method);
}
if ($path === '/site-api/v1/health' && $method === 'GET') respond(200, ['status' => 'ok']);
if ($path !== '/site-api/v1/staff-registrations') respond(404, ['message' => 'Rota não encontrada.']);
if ($method !== 'POST') {
    header('Allow: POST');
    respond(405, ['message' => 'Método não permitido.']);
}
if (strtolower(trim(explode(';', $_SERVER['CONTENT_TYPE'] ?? '')[0])) !== 'application/json') respond(415, ['message' => 'Envie os dados em JSON.']);
if ((int) ($_SERVER['CONTENT_LENGTH'] ?? 0) > 32768) respond(413, ['message' => 'Formulário muito grande.']);
$raw = file_get_contents('php://input', false, null, 0, 32769);
if (strlen($raw) > 32768) respond(413, ['message' => 'Formulário muito grande.']);
try { $input = json_decode($raw, true, 64, JSON_THROW_ON_ERROR); }
catch (JsonException) { respond(400, ['message' => 'JSON inválido.']); }
if (!is_array($input) || array_is_list($input)) respond(400, ['message' => 'Formulário inválido.']);
[$data, $errors] = validateStaff($input);
if ($errors) respond(422, ['message' => 'Revise os campos indicados.', 'errors' => $errors]);
try {
    $db = siteDatabase();
    // Persisted rate counter: independent of PHP workers and without storing raw IPs.
    $hash = hash('sha256', $_SERVER['REMOTE_ADDR'] ?? 'unknown');
    $bucket = intdiv(time(), 3600);
    $counter = $db->prepare('INSERT INTO site_request_limits (client_hash, bucket, attempts) VALUES (?, ?, LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE attempts = LAST_INSERT_ID(attempts + 1)');
    $counter->execute([$hash, $bucket]);
    $attempts = (int) $db->query('SELECT LAST_INSERT_ID()')->fetchColumn();
    if ($attempts > 10) {
        header('Retry-After: ' . (3600 - time() % 3600));
        respond(429, ['message' => 'Muitas tentativas. Aguarde antes de enviar novamente.']);
    }
    $db->exec('DELETE FROM site_request_limits WHERE bucket < ' . ($bucket - 24));
    $statement = $db->prepare('INSERT INTO staff_registrations (event_year, name, email, birth_date, answers, specification_version) VALUES (2027, ?, ?, ?, ?, ?)');
    $statement->execute([$data['nome'], strtolower($data['email']), $data['dataNascimento'], json_encode($data, JSON_UNESCAPED_UNICODE | JSON_THROW_ON_ERROR), 'staff-2027-v1']);
    respond(201, ['message' => 'Inscrição recebida.']);
} catch (PDOException $error) {
    if (($error->errorInfo[1] ?? null) === 1062) respond(409, ['message' => 'Já existe uma inscrição para este e-mail em 2027. Para corrigir seus dados, entre em contato com a organização.']);
    error_log('Ultra Site registration database failure: ' . $error->getCode());
    respond(503, ['message' => 'Serviço temporariamente indisponível. Tente novamente mais tarde.']);
} catch (Throwable $error) {
    error_log('Ultra Site registration failure: ' . get_class($error));
    respond(503, ['message' => 'Serviço temporariamente indisponível. Tente novamente mais tarde.']);
}
