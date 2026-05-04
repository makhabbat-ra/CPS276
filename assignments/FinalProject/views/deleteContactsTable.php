<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php?page=login');
    exit;
}

require_once __DIR__ . '/../classes/Db_conn.php';
require_once __DIR__ . '/../classes/Pdo_methods.php';

$pdo = new Pdo_methods();
$sql = "SELECT id, fname, lname, address, city, state, phone, email, dob, contacts, age
        FROM contacts
        ORDER BY lname, fname";
$records = $pdo->selectBinded($sql, []);

$success = $_SESSION['delete_contacts_success'] ?? null;
$error   = $_SESSION['delete_contacts_error'] ?? null;
unset($_SESSION['delete_contacts_success'], $_SESSION['delete_contacts_error']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Delete Contacts</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-11">
        <h2 class="mb-4">Delete Contact(s)</h2>

        <?php if ($success): ?>
          <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>


        <?php
        if ($records === 'error') {
            echo '<div class="alert alert-danger">There was an error retrieving the contact records.</div>';
        } elseif (empty($records)) {
            echo '<div class="alert alert-info">There are no records to display</div>';
        } else {
        ?>
          <form method="post" action="controllers/deleteContactProc.php">

            <div class="table-responsive">
              <table class="table table-striped table-bordered align-middle">
                <thead class="table-light">
                  <tr>
                    <th scope="col">First Name</th>
                    <th scope="col">Last Name</th>
                    <th scope="col">Address</th>
                    <th scope="col">City</th>
                    <th scope="col">State</th>
                    <th scope="col">Phone</th>
                    <th scope="col">Email</th>
                    <th scope="col">DOB</th>
                    <th scope="col">Contacts</th>
                    <th scope="col">Age</th>
                    <th scope="col" class="text-center">Delete</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($records as $row): ?>
                    <tr>
                      <td><?= htmlspecialchars($row['fname']) ?></td>
                      <td><?= htmlspecialchars($row['lname']) ?></td>
                      <td><?= htmlspecialchars($row['address']) ?></td>
                      <td><?= htmlspecialchars($row['city']) ?></td>
                      <td><?= htmlspecialchars($row['state']) ?></td>
                      <td><?= htmlspecialchars($row['phone']) ?></td>
                      <td><?= htmlspecialchars($row['email']) ?></td>
                      <td><?= htmlspecialchars($row['dob']) ?></td>
                      <td><?= htmlspecialchars($row['contacts']) ?></td>
                      <td><?= htmlspecialchars($row['age']) ?></td>
                      <td class="text-center">
                        <input type="checkbox" name="delete_ids[]" value="<?= (int)$row['id'] ?>">
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
