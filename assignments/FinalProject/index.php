<?php

declare(strict_types=1);

ini_set('display_errors', '0');
error_reporting(0);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/routes/router.php';
