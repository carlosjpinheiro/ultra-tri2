<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') exit(1);
$source = getenv('ULTRA_SITE_TEST_CONFIG');
if (!$source || !is_file($source)) throw new RuntimeException('Set ULTRA_SITE_TEST_CONFIG to a local config.');
$config = require $source;
if (!in_array($config['host'], ['localhost', '127.0.0.1'], true)) throw new RuntimeException('Only local MySQL allowed.');
$name = getenv('SITE_ADMIN_TEST_DB');
if (!is_string($name) || !preg_match('/^us_admin_test_[a-f0-9]{16}$/D', $name)) throw new RuntimeException('Invalid test database name.');
$db = new PDO("mysql:host={$config['host']};charset=utf8mb4", $config['user'], $config['password'], [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$action = $argv[1] ?? '';
if ($action === 'drop') { $db->exec("DROP DATABASE IF EXISTS `$name`"); exit; }
if ($action === 'setup') {
    $db->exec("CREATE DATABASE `$name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $db->exec("USE `$name`");
    foreach (glob(__DIR__ . '/../database/site-migrations/*.sql') as $file) $db->exec(file_get_contents($file));
    $config['name'] = $name;
    file_put_contents(getenv('ULTRA_SITE_DB_CONFIG'), '<?php return ' . var_export($config, true) . ';');
    $q = $db->prepare('INSERT INTO site_admin_users (name,email,password_hash) VALUES (?,?,?)');
    $q->execute(['Admin Teste', 'admin@example.com', password_hash('Test-password-2027!', PASSWORD_DEFAULT)]);
    $q = $db->prepare('INSERT INTO staff_registrations (event_year,name,email,birth_date,answers,specification_version) VALUES (2027,?,?,?, ?,?)');
    for ($i = 1; $i <= 25; $i++) {
        $answers = ['nome' => "Staff Teste $i", 'email' => "staff$i@example.com", 'whatsapp' => '(21) 99999-9999', 'cidadeEstado' => 'Búzios / RJ', 'departamentos' => ['Suporte aos Atletas'], 'motivacao' => 'Quero fazer parte da equipe. <script>alert(1)</script>'];
        $q->execute([$answers['nome'], $answers['email'], '1990-01-01', json_encode($answers), 'staff-2027-v1']);
    }
    exit;
}
$db->exec("USE `$name`");
if ($action === 'disable') $db->exec('UPDATE site_admin_users SET active=0');
elseif ($action === 'enable') $db->exec("UPDATE site_admin_users SET active=1, role='admin'");
elseif ($action === 'restrict') $db->exec("UPDATE site_admin_users SET role='viewer'");
elseif ($action === 'expire') {
    session_name('ultra_site_admin');
    session_id(getenv('SITE_ADMIN_TEST_SESSION'));
    session_start();
    $_SESSION['last_seen'] = time() - 3601;
    session_write_close();
} else throw new RuntimeException('Unknown action.');
