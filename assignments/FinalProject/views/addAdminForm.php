<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['admin_id']) || !isset($_SESSION['status']) || $_SESSION['status'] !== 'admin') {
    header('Location: index.php?page=login');
    exit;
}

$old = $_SESSION['admin_data'] ?? ['name' => '', 'email' => '', 'status' => ''];
$errors = $_SESSION['admin_errors'] ?? [];
$success = $_SESSION['admin_success'] ?? null;

unset($_SESSION['admin_errors'], $_SESSION['admin_success']);

?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <h2 class="mb-4">Add Admin</h2>

        <?php if ($success): ?>
          <div class="alert alert-success" role="alert">
            <?= htmlspecialchars($success) ?>
          </div>
        <?php endif; ?>

        <?php if (isset($errors['general'])): ?>
          <div class="alert alert-danger" role="alert">
            <?= htmlspecialchars($errors['general']) ?>
          </div>
        <?php endif; ?>

        <form method="post" action="controllers/addAdminProc.php" novalidate>

  <div class="row mb-3">
    <div class="col">
      <label for="fname" class="form-label">First Name</label>
      <input
        type="text"
        class="form-control <?= isset($errors['fname']) ? 'is-invalid' : '' ?>"
        id="fname"
        name="fname"
        value="<?= htmlspecialchars($old['fname'] ?? '') ?>"
      >
      <?php if (isset($errors['fname'])): ?>
        <div class="invalid-feedback">
          <?= htmlspecialchars($errors['fname']) ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="col">
      <label for="lname" class="form-label">Last Name</label>
      <input
        type="text"
        class="form-control <?= isset($errors['lname']) ? 'is-invalid' : '' ?>"
        id="lname"
        name="lname"
        value="<?= htmlspecialchars($old['lname'] ?? '') ?>"
      >
      <?php if (isset($errors['lname'])): ?>
        <div class="invalid-feedback">
          <?= htmlspecialchars($errors['lname']) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="row mb-3">
    <div class="col">
      <label for="email" class="form-label">Email</label>
      <input
        type="text"
        class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
        id="email"
        name="email"
        value="<?= htmlspecialchars($old['email'] ?? '') ?>"
      >
      <?php if (isset($errors['email'])): ?>
        <div class="invalid-feedback">
          <?= htmlspecialchars($errors['email']) ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="col">
      <label for="password" class="form-label">Password</label>
      <input
        type="password"
        class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
        id="password"
        name="password"
      >
      <?php if (isset($errors['password'])): ?>
        <div class="invalid-feedback">
          <?= htmlspecialchars($errors['password']) ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="col">
      <label for="status" class="form-label">Status</label>
      <select
        class="form-select <?= isset($errors['status']) ? 'is-invalid' : '' ?>"
        id="status"
        name="status"
      >
        <option value="">-- Select --</option>
        <option value="staff" <?= ($old['status'] ?? '') === 'staff' ? 'selected' : '' ?>>staff</option>
        <option value="admin" <?= ($old['status'] ?? '') === 'admin' ? 'selected' : '' ?>>admin</option>
      </select>
      <?php if (isset($errors['status'])): ?>
        <div class="invalid-feedback">
          <?= htmlspecialchars($errors['status']) ?>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <div class="d-flex gap-2">
    <button type="submit" class="btn btn-primary">Add Admin</button>
  </div>

</form>

      </div>
    </div>
  </div>
</body>
</html>
