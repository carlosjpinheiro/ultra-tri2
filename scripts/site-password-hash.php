<?php
declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    http_response_code(404);
    exit;
}

$password = rtrim(stream_get_contents(STDIN), "\r\n");
if (strlen($password) < 12 || strlen($password) > 72 || str_contains($password, "\0")) {
    fwrite(STDERR, "Use uma senha de 12 a 72 bytes, sem caracteres nulos.\n");
    exit(1);
}

echo password_hash($password, PASSWORD_DEFAULT), PHP_EOL;
