<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/../includes/security.php';

$validPages = [
    'login',
    'welcome',
    'addContact',
    'deleteContacts',
    'addAdmin',
    'deleteAdmins'
];

$page = $_GET['page'] ?? 'login';

if (!in_array($page, $validPages, true)) {
    header('Location: index.php?page=login');
    exit;
}

if (!isAllowed($page)) {
    // If not allowed, always redirect to login page
    header('Location: index.php?page=login');
    exit;
}

$viewPath = __DIR__ . '/../views/' . $page . 'Form.php';

switch ($page) {
    case 'login':
        $viewPath = __DIR__ . '/../views/loginForm.php';
        break;
    case 'welcome':
        $viewPath = __DIR__ . '/../views/welcome.php';
        break;
    case 'addContact':
        $viewPath = __DIR__ . '/../views/addContactForm.php';
        break;
    case 'deleteContacts':
        $viewPath = __DIR__ . '/../views/deleteContactsTable.php';
        break;
    case 'addAdmin':
        $viewPath = __DIR__ . '/../views/addAdminForm.php';
        break;
    case 'deleteAdmins':
        $viewPath = __DIR__ . '/../views/deleteAdminsTable.php';
        break;
    default:
        header('Location: index.php?page=login');
        exit;
}
if (!file_exists($viewPath)) {
    header('Location: index.php?page=login');
    exit;
}

include $viewPath;
