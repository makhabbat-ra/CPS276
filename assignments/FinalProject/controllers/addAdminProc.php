<?php
session_start();

require_once __DIR__ . '/../classes/Db_conn.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';
require_once __DIR__ . '/../classes/Validation.php';

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$status   = trim($_POST['status'] ?? '');

$val = new Validation();
$errors = [];
$data = [
  'name'  => $name,
  'email' => $email,
  'status'=> $status
];

if ($name === '' || !$val->checkFormat($name, 'name')) {
  $errors['name'] = 'Name must contain only letters, hyphens, apostrophes, and spaces';
}

if ($email === '' || !$val->checkFormat($email, 'email')) {
  $errors['email'] = 'Enter a valid email address';
}

if ($password === '' || !$val->checkFormat($password, 'password')) {
  $errors['password'] = 'Password must be at least 8 characters, include an uppercase letter, a number, and a special character';
}

if ($status !== 'staff' && $status !== 'admin') {
  $errors['status'] = 'Select a valid status';
}


if (!empty($errors)) {
  $_SESSION['admin_errors'] = $errors;
  $_SESSION['admin_data'] = $data;
  header('Location: ../index.php?page=addAdmin');
  exit;
}

$pdo = new Pdo_methods();
$checkSql = "SELECT id FROM admins WHERE email = :email";
$bind = [
  [':email', $email, 'str']
];
$existing = $pdo->selectBinded($checkSql, $bind);

if ($existing !== 'error' && count($existing) > 0) {
  $_SESSION['admin_errors'] = ['email' => 'An account with that email already exists'];
  $_SESSION['admin_data'] = $data;
  header('Location: ../index.php?page=addAdmin');
  exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$insertSql = "INSERT INTO admins (name, email, password, status)
              VALUES (:name, :email, :password, :status)";
$insertBind = [
  [':name', $name, 'str'],
  [':email', $email, 'str'],
  [':password', $hash, 'str'],
  [':status', $status, 'str']
];

$insertResult = $pdo->otherBinded($insertSql, $insertBind);

if ($insertResult === 'error') {
  // DB error while inserting
  $_SESSION['admin_errors'] = ['general' => 'There was an error adding the admin'];
  $_SESSION['admin_data'] = $data;
  header('Location: ../index.php?page=addAdmin');
  exit;
}

unset($_SESSION['admin_data']);
$_SESSION['admin_success'] = 'Admin Added';
header('Location: ../index.php?page=addAdmin');
exit;

