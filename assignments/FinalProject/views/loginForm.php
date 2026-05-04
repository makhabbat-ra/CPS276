<?php
if (!isset($_SESSION)) session_start();

if (isset($_SESSION['admin_id'])) {
    header('Location: index.php?page=welcome');
    exit;
}

$old = $_SESSION['login_data'] ?? ['email' => ''];
$errors = $_SESSION['login_errors'] ?? [];

unset($_SESSION['login_errors'], $_SESSION['login_data']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    .login-card {
      max-width: 480px;
    }
    .login-card .card-body {
      text-align: left;
    }
    /* Make the main heading large and bold */
    .login-title {
      font-weight: 700;
      font-size: 2.25rem; /* large */
      margin-bottom: 1rem;
    }

    
    .login-card {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      width: 100%;
      height: 100vh;
      max-width: none;
      margin: 0;
      padding: 0;
      background: #ffffff; 
      border: none;
      box-shadow: none;
      box-sizing: border-box;
      overflow: auto; 
    }

    .login-card .card-body {
      padding: 2rem;
    }
  </style>
</head>
<body class="bg-light">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-12 col-md-8 col-lg-6">
        <div class="card shadow-sm login-card">
          <div class="card-body">
            <h1 class="login-title">Login</h1>

            <?php if (isset($errors['general'])): ?>
              <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
            <?php endif; ?>

            <form method="post" action="controllers/loginProc.php" novalidate>
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input
                  type="text"
                  class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>"
                  id="email"
                  name="email"
                  value="<?= htmlspecialchars($old['email'] ?? '') ?>"
                >
                <?php if (isset($errors['email'])): ?>
                  <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                <?php endif; ?>
              </div>

              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input
                  type="password"
                  class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>"
                  id="password"
                  name="password"
                >
                <?php if (isset($errors['password'])): ?>
                  <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                <?php endif; ?>
              </div>

              <div>
                <button type="submit" class="btn btn-primary btn-small">Login</button>
              </div>
            </form>

            
          </div>
        </div>
      </div>
    </div>
  </div>

</body>
</html>
