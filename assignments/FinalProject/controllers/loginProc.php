<?php
session_start();
require_once __DIR__ . '/../classes/Db_conn.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';
require_once __DIR__ . '/../classes/Validation.php';

$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

$val = new Validation();
$errors = [];

if (!(new Validation())->checkFormat($email, 'email'));
if ($password === '') $errors['password'] = 'Password cannot be blank';

if ($errors) {
  $_SESSION['login_errors'] = $errors;
  $_SESSION['login_data'] = ['email'=>$email];
  header('Location: ../index.php?page=login');
  exit;
}

$pdo = new Pdo_methods();
$sql = "SELECT id,name,email,password,status FROM admins WHERE email = :email";
$bind = [ [':email',$email,'str'] ];
$records = $pdo->selectBinded($sql,$bind);

if ($records === 'error' || count($records) === 0) {
  $_SESSION['login_errors']['general'] = 'Invalid credentials';
  header('Location: ../index.php?page=login');
  exit;
}

$user = $records[0];
if (!password_verify($password, $user['password'])) {
  $_SESSION['login_errors']['general'] = 'Invalid credentials';
  header('Location: ../index.php?page=login');
  exit;
}

$_SESSION['admin_id'] = $user['id'];
$_SESSION['name'] = $user['name'];
$_SESSION['status'] = $user['status'];

header('Location: ../index.php?page=welcome');
