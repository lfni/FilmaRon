<?php
require_once __DIR__ . '/db.php';
session_start();
function find_user_by_username_or_email($identity){
  global $pdo;
  $stmt = $pdo->prepare("SELECT * FROM users WHERE username=:id OR email=:id LIMIT 1");
  $stmt->execute(['id'=>$identity]);
  return $stmt->fetch();
}
function create_user($username,$email,$password){
  global $pdo;
  $hash = password_hash($password, PASSWORD_BCRYPT);
  $stmt = $pdo->prepare("INSERT INTO users (username,email,password_hash) VALUES (:u,:e,:p)");
  $stmt->execute(['u'=>$username,'e'=>$email,'p'=>$hash]);
  return $pdo->lastInsertId();
}
function login_user($user){ $_SESSION['user'] = ['id'=>$user['id'],'username'=>$user['username'],'email'=>$user['email']]; }
function logout_user(){ $_SESSION = []; session_destroy(); }
