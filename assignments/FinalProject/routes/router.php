<?php
// Routes/router.php

// Ensure session is started (index.php should have started it already)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Include security helper (it should not call session_start again)
require_once __DIR__ . '/../includes/security.php';

// Allowed pages exactly as specified
$validPages = [
    'login',
    'welcome',
    'addContact',
    'deleteContacts',
    'addAdmin',
    'deleteAdmins'
];

// Read page param from URL (index.php?page=...)
$page = $_GET['page'] ?? 'login';

// If page not in allowed list, redirect to login
if (!in_array($page, $validPages, true)) {
    header('Location: index.php?page=login');
    exit;
}

// Security check: is the user allowed to view this page?
if (!isAllowed($page)) {
    // If not allowed, always redirect to login page
    header('Location: index.php?page=login');
    exit;
}

// Map page to view file in Views folder
$viewPath = __DIR__ . '/../views/' . $page . 'Form.php';

// Special-case welcome and delete pages that use different filenames
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
        // fallback to login
        header('Location: index.php?page=login');
        exit;
}

// Final check: view file must exist
if (!file_exists($viewPath)) {
    // If a view file is missing, redirect to login to avoid exposing errors
    header('Location: index.php?page=login');
    exit;
}

// Include the view
include $viewPath;
