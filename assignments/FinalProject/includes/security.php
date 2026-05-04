<?php
session_start();

function isLoggedIn() {
  return isset($_SESSION['admin_id']);
}

function isAdmin() {
  return isset($_SESSION['status']) && $_SESSION['status'] === 'admin';
}

function isAllowed($page) {
  if ($page === 'login') return true;
  if (!isLoggedIn()) return false;
  $adminOnly = ['addAdmin','deleteAdmins'];
  if (in_array($page, $adminOnly) && !isAdmin()) return false;
  return true;
}
