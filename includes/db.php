<?php
$config = require __DIR__ . '/../config.php';
$cfg = $config['db'];
try {
  $pdo = new PDO("mysql:host={$cfg['host']};dbname={$cfg['name']};charset=utf8mb4", $cfg['user'], $cfg['pass'], [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]);
} catch (PDOException $e) { die('DB connection failed: ' . $e->getMessage()); }
