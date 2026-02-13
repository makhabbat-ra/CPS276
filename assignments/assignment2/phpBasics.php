<?php
$numbers = range(1, 50);
$evenNumbers = "";

foreach ($numbers as $num) {
    if ($num % 2 === 0) {
        $evenNumbers .= $num . " - ";
    }
}

$evenNumbers = rtrim($evenNumbers, " - ");

$form = <<<FORM
<form class="mt-4">

    <div class="mb-3">
        <label for="emailInput" class="form-label">Email address</label>
        <input type="email" class="form-control" id="emailInput" placeholder="name@example.com">
    </div>

    <div class="mb-3">
        <label for="exampleTextarea" class="form-label">Example textarea</label>
        <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
    </div>
</form>
FORM;

function createTable($rows, $columns) {
    $table = "<table class=\"table table-bordered mt-4\">\n";

    for ($r = 1; $r <= $rows; $r++) {
        $table .= "    <tr>\n";
        for ($c = 1; $c <= $columns; $c++) {
            $table .= "        <td>Row {$r}, Col {$c}</td>\n";
        }
        $table .= "    </tr>\n";
    }

    $table .= "</table>";

    return $table;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Form Project</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container">
    <?php
        echo "Even Numbers: ", $evenNumbers;
        echo $form;
        echo createTable(8, 6);
    ?>
</body>
</html>
