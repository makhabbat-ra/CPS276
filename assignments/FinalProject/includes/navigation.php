<?php
if (!isset($_SESSION)) session_start();
?>
<style>
    .nav-link {
      color: blue !important;
    }
  </style>
</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
  <div class="container">
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav me-auto">
        <li class="nav-item"><a class="nav-link" href="index.php?page=addContact">Add Contact</a></li>
        <li class="nav-item"><a class="nav-link" href="index.php?page=deleteContacts">Delete Contact(s)</a></li>
        <?php if (isset($_SESSION['status']) && $_SESSION['status'] === 'admin'): ?>
          <li class="nav-item"><a class="nav-link" href="index.php?page=addAdmin">Add Admin</a></li>
          <li class="nav-item"><a class="nav-link" href="index.php?page=deleteAdmins">Delete Admin(s)</a></li>
        <?php endif; ?>
        <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
      </ul>
    </div>
  </div>
</nav>
