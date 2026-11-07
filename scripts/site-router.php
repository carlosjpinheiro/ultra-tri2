<?php
// Development only: php -S 127.0.0.1:8001 scripts/site-router.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
if (str_starts_with($path, '/site-api/v1/')) require __DIR__ . '/../site-api/index.php';
else { http_response_code(404); }
