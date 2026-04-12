<?php
require_once 'classes/Db_conn.php';
require_once 'classes/Pdo_methods.php';
require_once 'classes/StickyForm.php';

$pdo = new PdoMethods();
$sticky = new StickyForm();

$output = '';

$formConfig = [
    'masterStatus' => ['error' => false],

    'first_name' => [
        'type' => 'text',
        'label' => 'First Name',
        'name' => 'first_name',
        'id' => 'first_name',
        'required' => true,
        'regex' => 'name',
        'error' => '',
        'value' => ''
    ],

    'last_name' => [
        'type' => 'text',
        'label' => 'Last Name',
        'name' => 'last_name',
        'id' => 'last_name',
        'required' => true,
        'regex' => 'name',
        'error' => '',
        'value' => ''
    ],

    'email' => [
        'type' => 'text',
        'label' => 'Email',
        'name' => 'email',
        'id' => 'email',
        'required' => true,
        'regex' => 'email',
        'error' => '',
        'value' => ''
    ],

    'password' => [
        'type' => 'password',
        'label' => 'Password',
        'name' => 'password',
        'id' => 'password',
        'required' => true,
        'regex' => 'password',
        'error' => '',
        'value' => ''
    ],

    'confirm' => [
        'type' => 'password',
        'label' => 'Confirm Password',
        'name' => 'confirm',
        'id' => 'confirm',
        'required' => true,
        'regex' => 'password',
        'error' => '',
        'value' => ''
    ]
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formConfig = $sticky->validateForm($_POST, $formConfig);


    if (!empty($formConfig['first_name']['error'])) {
        $formConfig['first_name']['error'] =
            "You must enter a first name and it must be alpha characters only.";
    }

    if (!empty($formConfig['last_name']['error'])) {
        $formConfig['last_name']['error'] =
            "You must enter a last name and it must be alpha characters only.";
    }

    if (!empty($formConfig['email']['error'])) {
        $formConfig['email']['error'] =
            "You must enter an email address and it must be in the format of example@example.com.";
    }

    if (!empty($formConfig['password']['error'])) {
        $formConfig['password']['error'] =
            "Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number).";
    }

    if (!empty($formConfig['confirm']['error'])) {
        $formConfig['confirm']['error'] =
            "Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number).";
    }

    if ($_POST['password'] !== $_POST['confirm']) {
        $formConfig['confirm']['error'] = "Passwords do not match.";
        $formConfig['masterStatus']['error'] = true;
    }

    if (!$formConfig['masterStatus']['error']) {
        $sql = "SELECT email FROM users WHERE email = :email";
        $bindings = [
            [':email', $_POST['email'], 'str']
        ];
        $result = $pdo->selectBinded($sql, $bindings);

        if ($result === 'error') {
            $output = "<p class='text-danger'>Database error occurred.</p>";
        } elseif (count($result) > 0) {
            $formConfig['email']['error'] = "This email is already registered.";
            $formConfig['masterStatus']['error'] = true;
        }
    }

    if (!$formConfig['masterStatus']['error']) {

        $sql = "INSERT INTO users (first_name, last_name, email, password)
                VALUES (:first_name, :last_name, :email, :password)";

        $bindings = [
            [':first_name', $_POST['first_name'], 'str'],
            [':last_name', $_POST['last_name'], 'str'],
            [':email', $_POST['email'], 'str'],
            [':password', $_POST['password'], 'str']
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === 'error') {
            $output = "<p class='text-danger'>Error inserting record.</p>";
        } else {
            $output = "<p class='text-success'>Record successfully added.</p>";

            foreach ($formConfig as $key => &$item) {
                if ($key !== 'masterStatus') {
                    $item['value'] = '';
                }
            }
        }
    }
}

$sql = "SELECT first_name, last_name, email, password FROM users ORDER BY id DESC";
$records = $pdo->selectNotBinded($sql);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap -->
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">

    <title>User Registration</title>

    <style>
        .text-danger { font-size: 0.9rem; }
    </style>
</head>

<body class="bg-white">

<div class="container mt-4">

    <p class="mb-4">
        <span class="text-dark">*</span> All fields are required
    </p>

    <?= $output ?>

    <form method="post" action="">

        <div class="form-row">
            <div class="col-md-6 mb-3">
                <?= $sticky->renderInput($formConfig['first_name']) ?>
            </div>

            <div class="col-md-6 mb-3">
                <?= $sticky->renderInput($formConfig['last_name']) ?>
            </div>
        </div>

        <div class="form-row">
            <div class="col-md-4 mb-3">
                <?= $sticky->renderInput($formConfig['email']) ?>
            </div>

            <div class="col-md-4 mb-3">
                <?= $sticky->renderPassword($formConfig['password']) ?>
            </div>

            <div class="col-md-4 mb-3">
                <?= $sticky->renderPassword($formConfig['confirm']) ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm mt-2">
            Register
        </button>

    </form>

    <hr class="my-5">

<?php
if ($records === 'error') {
    echo "<p class='text-danger'>Error retrieving records.</p>";
} elseif (count($records) === 0) {
    echo "<p>No records found.</p>";
} else {

    echo "<table class='table table-bordered mt-3'>
            <thead>
                <tr style='background-color: white; font-weight: bold;'>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>";

    foreach ($records as $row) {

        // Hash the password for display (never show real password)
        $hashedDisplay = password_hash($row['password'], PASSWORD_DEFAULT);

        echo "<tr>
                <td>{$row['first_name']}</td>
                <td>{$row['last_name']}</td>
                <td>{$row['email']}</td>
                <td style='font-family: monospace; font-size: 0.85rem;'>{$hashedDisplay}</td>
              </tr>";
    }

    echo "</tbody></table>";
}
?>

</div>

</body>
</html>