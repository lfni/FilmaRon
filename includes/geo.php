<?php
function is_ip_from_iran(): bool {
  $config = require __DIR__ . '/../config.php';
  if(($config['geo']['provider'] ?? 'none') === 'none') return false;
  $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
  if(isset($_GET['force_ir']) && $_GET['force_ir']=='1') return true;
  $ctx = stream_context_create(['http' => ['timeout' => (int)($config['geo']['timeout'] ?? 2)]]);
  $resp = @file_get_contents("https://ipapi.co/{$ip}/country/", false, $ctx);
  if(!$resp) return false;
  return strtoupper(trim($resp)) === 'IR';
}
