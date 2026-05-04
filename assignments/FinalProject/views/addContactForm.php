<?php
if (!isset($_SESSION)) session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: index.php?page=login');
    exit;
}

$old = $_SESSION['contact_data'] ?? [
    'fname'    => '',
    'lname'    => '',
    'address'  => '',
    'city'     => '',
    'state'    => '',
    'phone'    => '',
    'email'    => '',
    'dob'      => '',
    'contacts' => '', 
    'age'      => ''
];
$errors = $_SESSION['contact_errors'] ?? [];
$success = $_SESSION['contact_success'] ?? null;

$oldContacts = [];
if (!empty($old['contacts'])) {
    $oldContacts = explode(';', $old['contacts']);
}

unset($_SESSION['contact_errors'], $_SESSION['contact_success']);
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Add Contact</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <?php include __DIR__ . '/../includes/navigation.php'; ?>

  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        <h2 class="mb-4">Add Contact</h2>

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

        <form method="post" action="controllers/addContactProc.php" novalidate>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="fname" class="form-label">First Name</label>
              <input
                type="text"
                class="form-control <?= isset($errors['fname']) ? 'is-invalid' : '' ?>"
                id="fname"
                name="fname"
                value="<?= htmlspecialchars($old['fname'] ?? '') ?>"
              >
              <?php if (isset($errors['fname'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['fname']) ?></div>
              <?php endif; ?>
            </div>

            <div class="col-md-6 mb-3">
              <label for="lname" class="form-label">Last Name</label>
              <input
                type="text"
                class="form-control <?= isset($errors['lname']) ? 'is-invalid' : '' ?>"
                id="lname"
                name="lname"
                value="<?= htmlspecialchars($old['lname'] ?? '') ?>"
              >
              <?php if (isset($errors['lname'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['lname']) ?></div>
              <?php endif; ?>
            </div>
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input
              type="text"
              class="form-control <?= isset($errors['address']) ? 'is-invalid' : '' ?>"
              id="address"
              name="address"
              value="<?= htmlspecialchars($old['address'] ?? '') ?>"
            >
            <?php if (isset($errors['address'])): ?>
              <div class="invalid-feedback"><?= htmlspecialchars($errors['address']) ?></div>
            <?php endif; ?>
          </div>

          <div class="row">
            <div class="col-md-4 mb-3">
              <label for="city" class="form-label">City</label>
              <input
                type="text"
                class="form-control <?= isset($errors['city']) ? 'is-invalid' : '' ?>"
                id="city"
                name="city"
                value="<?= htmlspecialchars($old['city'] ?? '') ?>"
              >
              <?php if (isset($errors['city'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['city']) ?></div>
              <?php endif; ?>
            </div>

            <div class="col-md-4 mb-3">
              <label for="state" class="form-label">State</label>
              <select
                id="state"
                name="state"
                class="form-select <?= isset($errors['state']) ? 'is-invalid' : '' ?>"
              >
                <option value="">-- Select State --</option>
                <option value="MI" <?= ($old['state'] === 'MI') ? 'selected' : '' ?>>Michigan</option>
                <option value="OH" <?= ($old['state'] === 'OH') ? 'selected' : '' ?>>Ohio</option>
                <option value="IN" <?= ($old['state'] === 'IN') ? 'selected' : '' ?>>Indiana</option>
                <option value="IL" <?= ($old['state'] === 'IL') ? 'selected' : '' ?>>Illinois</option>
                <option value="WI" <?= ($old['state'] === 'WI') ? 'selected' : '' ?>>Wisconsin</option>
              </select>
              <?php if (isset($errors['state'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['state']) ?></div>
              <?php endif; ?>
            </div>

            <div class="col-md-4 mb-3">
              <label for="phone" class="form-label">Phone (999.999.9999)</label>
              <input
                type="text"
                class="form-control <?= isset($errors['phone']) ? 'is-invalid' : '' ?>"
                id="phone"
                name="phone"
                value="<?= htmlspecialchars($old['phone'] ?? '') ?>"
              >
              <?php if (isset($errors['phone'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['phone']) ?></div>
              <?php endif; ?>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6 mb-3">
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

            <div class="col-md-6 mb-3">
              <label for="dob" class="form-label">Date of Birth</label>
              <input
                type="text"
                class="form-control <?= isset($errors['dob']) ? 'is-invalid' : '' ?>"
                id="dob"
                name="dob"
                value="<?= htmlspecialchars($old['dob'] ?? '') ?>"
              >
              <?php if (isset($errors['dob'])): ?>
                <div class="invalid-feedback"><?= htmlspecialchars($errors['dob']) ?></div>
              <?php endif; ?>
            </div>
          </div>

           <div class="mb-3">
  <label class="form-label d-block">Choose an Age Range</label>

  <div class="d-flex gap-4">

    <div class="form-check">
      <input class="form-check-input" type="radio" name="age" id="age1" value="<18"
        <?= ($old['age'] === '<18') ? 'checked' : '' ?>>
      <label class="form-check-label" for="age1">&lt; 18</label>
    </div>

    <div class="form-check">
      <input class="form-check-input" type="radio" name="age" id="age2" value="18-35"
        <?= ($old['age'] === '18-35') ? 'checked' : '' ?>>
      <label class="form-check-label" for="age2">18 - 35</label>
    </div>

    <div class="form-check">
      <input class="form-check-input" type="radio" name="age" id="age3" value="36-55"
        <?= ($old['age'] === '36-55') ? 'checked' : '' ?>>
      <label class="form-check-label" for="age3">36 - 55</label>
    </div>

    <div class="form-check">
      <input class="form-check-input" type="radio" name="age" id="age4" value="55+"
        <?= ($old['age'] === '55+') ? 'checked' : '' ?>>
      <label class="form-check-label" for="age4">55+</label>
    </div>
              </div>
          <div class="mb-3">
            <label class="form-label d-block">Select One or More Options</label>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="contact_mail" name="contacts[]" value="Mail"
                <?= in_array('Mail', $oldContacts) ? 'checked' : '' ?>>
              <label class="form-check-label" for="contact_mail">newsletter</label>
            </div>
            
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="contact_email" name="contacts[]" value="Email"
                <?= in_array('Email', $oldContacts) ? 'checked' : '' ?>>
              <label class="form-check-label" for="contact_email">email</label>
            </div>

            <div class="form-check form-check-inline">
              <input class="form-check-input" type="checkbox" id="contact_phone" name="contacts[]" value="Phone"
                <?= in_array('Phone', $oldContacts) ? 'checked' : '' ?>>
              <label class="form-check-label" for="contact_phone">text</label>
            </div>

            
          

          

  <?php if (isset($errors['age'])): ?>
    <div class="text-danger"><?= htmlspecialchars($errors['age']) ?></div>
  <?php endif; ?>
</div>


          <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Add Contact</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
