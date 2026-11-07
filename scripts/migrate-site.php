<?php
declare(strict_types=1);
if (PHP_SAPI !== 'cli') { http_response_code(404); exit; }
require __DIR__ . '/../site-api/src/Database.php';
$db = siteDatabase();
$lock = 'ultra_site_migrations_' . substr(hash('sha256', (string) $db->query('SELECT DATABASE()')->fetchColumn()), 0, 24);
$stmt = $db->prepare('SELECT GET_LOCK(?, 0)');
$stmt->execute([$lock]);
if ((int) $stmt->fetchColumn() !== 1) throw new RuntimeException('Another migration is running.');
try {
    $db->exec('CREATE TABLE IF NOT EXISTS site_schema_migrations (version VARCHAR(190) PRIMARY KEY, checksum CHAR(64) NOT NULL, applied_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP) ENGINE=InnoDB');
    foreach (glob(__DIR__ . '/../database/site-migrations/*.sql') as $file) {
        $version = basename($file);
        $checksum = hash_file('sha256', $file);
        $stmt = $db->prepare('SELECT checksum FROM site_schema_migrations WHERE version = ?');
        $stmt->execute([$version]);
        $existing = $stmt->fetchColumn();
        if ($existing !== false) {
            if (!hash_equals($existing, $checksum)) throw new RuntimeException('Applied migration changed: ' . $version);
            continue;
        }
        // MySQL DDL commits implicitly. Stop on errors; never mark a partial migration applied.
        $db->exec(file_get_contents($file));
        $stmt = $db->prepare('INSERT INTO site_schema_migrations (version, checksum) VALUES (?, ?)');
        $stmt->execute([$version, $checksum]);
        echo "Applied $version\n";
    }
    echo "Site migrations up to date.\n";
} finally {
    $stmt = $db->prepare('SELECT RELEASE_LOCK(?)');
    $stmt->execute([$lock]);
}
