<?php
session_start();
require_once __DIR__ . '/../classes/Pdo_methods.php';

$ids = $_POST['delete_ids'] ?? [];

if (empty($ids)) {
  header('Location: ../index.php?page=deleteContacts');
  exit;
}

$placeholders = implode(',', array_fill(0, count($ids), '?'));
$sql = "DELETE FROM contacts WHERE id IN ($placeholders)";
$pdo = new Pdo_methods();
$result = $pdo->other($sql, $ids);

if ($result === 'error') {
  $_SESSION['delete_contacts_error'] = 'Could not delete the contacts';
} else {
  $_SESSION['delete_contacts_success'] = 'Contact(s) deleted';
}
header('Location: ../index.php?page=deleteContacts');
