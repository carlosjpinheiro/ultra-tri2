<?php
declare(strict_types=1);

function siteDatabase(): PDO
{
    $localPath = dirname(__DIR__, 2) . '/config.site.local.php';
    $localDevelopment = in_array(PHP_SAPI, ['cli', 'cli-server'], true) && is_file($localPath);
    $path = getenv('ULTRA_SITE_DB_CONFIG')
        ?: ($localDevelopment ? $localPath : dirname(__DIR__, 3) . '/ultra-site/db.php');
    if (!is_file($path)) throw new RuntimeException('Site database configuration missing.');
    $config = require $path;
    return new PDO(
        "mysql:host={$config['host']};dbname={$config['name']};charset=utf8mb4",
        $config['user'], $config['password'],
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false]
    );
}
