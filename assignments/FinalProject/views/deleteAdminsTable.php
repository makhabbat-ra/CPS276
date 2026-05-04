<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../classes/Db_conn.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';

$pdo = new Pdo_methods();
$sql = "SELECT id, name, email, status FROM admins ORDER BY name";
$bind = []; // no bound params
$records = $pdo->selectBinded($sql, $bind);

$success = $_SESSION['delete_admins_success'] ?? null;
$error   = $_SESSION['delete_admins_error'] ?? null;
unset($_SESSION['delete_admins_success'], $_SESSION['delete_admins_error']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete Admins</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <h2 class="mb-4">Delete Admins</h2>

        <?php if ($success): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php

        if ($records === 'error') {
            echo '<div class="alert alert-danger">There was an error retrieving the admin records.</div>';
        } elseif (empty($records)) {
            echo '<div class="alert alert-info">There are no records to display</div>';
        } else {
        ?>
          <form method="post" action="controllers/deleteAdminProc.php">  

            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col" class="text-center">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($records as $row): ?>
                    <tr>
                      <td><?= htmlspecialchars($row['name']) ?><?= ($row['id'] == $_SESSION['admin_id']) ? ' <span class="badge bg-secondary">you</span>' : '' ?></td>
                      <td><?= htmlspecialchars($row['email']) ?></td>
                      <td><?= htmlspecialchars($row['status']) ?></td>
                      <td class="text-center">
                        <?php if ($row['id'] == $_SESSION['admin_id']): ?>
                          
                          <input type="checkbox" disabled>
                        <?php else: ?>
                          <input type="checkbox" name="delete_ids[]" value="<?= (int)$row['id'] ?>">
                        <?php endif; ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-danger">Delete</button>
            </div>
          </form>
        <?php } ?>
      </div>
    </div>
  </div>
</body>
</html>
