<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$name = $_SESSION['name'] ?? 'User';
$status = $_SESSION['status'] ?? 'staff';
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Welcome</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

  <style>
    html, body {
      height: 100%;
      margin: 0;
      background: #ffffff;
    }

    .fullpage-card {
      height: 100vh;      
      width: 100%;        
      border-radius: 0;   
    }
  </style>
</head>
<body>

  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="fullpage-card card shadow-sm">
    <div class="card-body p-5">

      <h1 class="card-title mb-3">Welcome Page</h1>

      <div class="text-small">
        Welcome <?= htmlspecialchars($name) ?>
      </div>

    </div>
  </div>

</body>
</html>
