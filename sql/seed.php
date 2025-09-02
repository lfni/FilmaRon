<?php
$config = require __DIR__ . '/../config.php';
$db = new PDO("mysql:host={$config['db']['host']};dbname={$config['db']['name']};charset=utf8mb4",
  $config['db']['user'],$config['db']['pass'],[PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
$sql = file_get_contents(__DIR__ . '/schema.sql');
$db->exec($sql);
echo "Database seeded.\n";
