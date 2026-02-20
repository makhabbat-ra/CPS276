<?php
$output = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'processNames.php';
    $output = addClearNames();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Names</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="container mt-4">

    <h1 class="mb-4">Add Names</h1>

    <form method="post" action="index.php">

        <div class="mb-3">
            <label for="fullname" class="form-label">Enter Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname">
        </div>

        <button type="submit" name="add" class="btn btn-primary">Add Name</button>
        <button type="submit" name="clear" class="btn btn-secondary">Clear Names</button>

        <div class="mt-4">
            <label for="namelist" class="form-label">List of Names</label>
            <textarea style="height: 500px;" class="form-control"
            id="namelist" name="namelist"><?php echo $output ?></textarea>
        </div>

    </form>

</body>
</html>