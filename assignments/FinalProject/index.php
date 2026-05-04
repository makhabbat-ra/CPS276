<?php

declare(strict_types=1);

ini_set('display_errors', '0');
error_reporting(0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/routes/router.php';

//1. What architectural pattern does this project use? 
// What are the benefits of separating routes, views, and controllers?
//2. How does the application enforce different permissions for staff vs. admin users? 
// What happens if a staff user tries to access an admin-only page?
//3. How does the navigation menu change based on user role? 
// Why is this important for user experience?
//4. How does the routing system work? What happens when a user requests a page that doesn't exist?
//5. How does the application handle database errors? 
// What user-facing messages are shown when operations fail?  
