<?php
function base_url(string $path=''): string {
  $config = require __DIR__ . '/config.php';
  $base = rtrim($config['app']['base_url'], '/');
  return $base . '/' . ltrim($path, '/');
}
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
function is_post(){ return $_SERVER['REQUEST_METHOD']==='POST'; }
function current_user(){ return $_SESSION['user'] ?? null; }
