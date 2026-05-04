<?php
session_start();
require_once __DIR__ . '/../classes/Validation.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';

$val = new Validation();
$data = [
  'fname'=>trim($_POST['fname'] ?? ''),
  'lname'=>trim($_POST['lname'] ?? ''),
  'address'=>trim($_POST['address'] ?? ''),
  'city'=>trim($_POST['city'] ?? ''),
  'state'=>trim($_POST['state'] ?? ''),
  'phone'=>trim($_POST['phone'] ?? ''),
  'email'=>trim($_POST['email'] ?? ''),
  'dob'=>trim($_POST['dob'] ?? ''),
  'contacts'=> isset($_POST['contacts']) ? implode(';', $_POST['contacts']) : '',
  'age'=> $_POST['age'] ?? ''
];

$errors = [];

// First name
if (!$val->checkFormat($data['fname'], 'name')) {
    $errors['fname'] = 'You must enter a first name and it must be alpha characters only.';
}

// Last name
if (!$val->checkFormat($data['lname'], 'name')) {
    $errors['lname'] = 'You must enter a last name and it must be alpha characters only.';
}

// Address (no pattern, so use 'none')
if (!$val->checkFormat($data['address'], 'none')) {
    $errors['address'] = 'Invalid address';
}

// City (letters only)
if (!$val->checkFormat($data['city'], 'name')) {
    $errors['city'] = 'Invalid city';
}

// Phone (you need a pattern — but for now use none)
if (!$val->checkFormat($data['phone'], 'none')) {
    $errors['phone'] = 'Phone must be 999.999.9999';
}

// Email
if (!$val->checkFormat($data['email'], 'email')) {
    $errors['email'] = 'Invalid email';
}

// DOB (no pattern in your class — so use none)
if (!$val->checkFormat($data['dob'], 'none')) {
    $errors['dob'] = 'DOB must be mm/dd/yyyy';
}

// State
if ($data['state'] === '') {
    $errors['state'] = 'Select a state';
}

// Age
if ($data['age'] === '') {
    $errors['age'] = 'You must select an age range';
}


if ($errors) {
  $_SESSION['contact_errors'] = $errors;
  $_SESSION['contact_data'] = $data;
  header('Location: ../index.php?page=addContact');
  exit;
}

$pdo = new Pdo_methods();
$sql = "INSERT INTO contacts (fname,lname,address,city,state,phone,email,dob,contacts,age)
        VALUES (:fname,:lname,:address,:city,:state,:phone,:email,:dob,:contacts,:age)";
$bind = [
  [':fname',$data['fname'],'str'],
  [':lname',$data['lname'],'str'],
  [':address',$data['address'],'str'],
  [':city',$data['city'],'str'],
  [':state',$data['state'],'str'],
  [':phone',$data['phone'],'str'],
  [':email',$data['email'],'str'],
  [':dob',$data['dob'],'str'],
  [':contacts',$data['contacts'],'str'],
  [':age',$data['age'],'str']
];

$result = $pdo->otherBinded($sql,$bind);
if ($result === 'error') {
  $_SESSION['contact_errors']['general'] = 'There was an error adding the record';
  $_SESSION['contact_data'] = $data;
  header('Location: ../index.php?page=addContact');
  exit;
}

$_SESSION['contact_success'] = 'Contact Information Added';
unset($_SESSION['contact_data']);
header('Location: ../index.php?page=addContact');
