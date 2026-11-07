<?php
$c = require (getenv('ULTRA_SITE_TEST_CONFIG') ?: throw new RuntimeException('Set ULTRA_SITE_TEST_CONFIG to a local MySQL config file'));
if (!in_array($c['host'], ['localhost','127.0.0.1'], true)) throw new RuntimeException('Local DB only');
$db = new PDO("mysql:host={$c['host']};charset=utf8mb4", $c['user'], $c['password'], [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$name='us_test_'.bin2hex(random_bytes(5));
$db->exec("CREATE DATABASE `$name` CHARACTER SET utf8mb4");
try {
 $db->exec("USE `$name`");
 $db->exec(file_get_contents(__DIR__.'/../database/site-migrations/001_staff_registrations.sql'));
 $stmt=$db->prepare('INSERT INTO staff_registrations (event_year,name,email,birth_date,answers,specification_version) VALUES (2027,?,?,?,?,?)');
 $stmt->execute(['Test','staff@example.com','1990-01-01','{"confirmacoes":["accepted"]}','staff-2027-v1']);
 if($db->query('SELECT COUNT(*) FROM staff_registrations')->fetchColumn()!=1) throw new RuntimeException('Insert failed');
 try {$stmt->execute(['Test','staff@example.com','1990-01-01','{}','staff-2027-v1']); throw new RuntimeException('Duplicate accepted');}
 catch(PDOException $e) {if(($e->errorInfo[1]??null)!==1062) throw $e;}
 $q=$db->prepare('INSERT INTO site_request_limits (client_hash,bucket,attempts) VALUES (?,1,LAST_INSERT_ID(1)) ON DUPLICATE KEY UPDATE attempts=LAST_INSERT_ID(attempts+1)');
 for($i=1;$i<=11;$i++) {$q->execute([str_repeat('a',64)]);if($db->query('SELECT LAST_INSERT_ID()')->fetchColumn()!=$i) throw new RuntimeException('Counter failed');}
 echo "MySQL migration, JSON persistence, duplicate protection and rate counter passed in isolated temporary DB.\n";
} finally {$db->exec("DROP DATABASE `$name`");}

