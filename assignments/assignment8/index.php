<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$output = $dt->addNote();
?>
<!DOCTYPE html>
<html>
<head>
<title>Add Note</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<h2>Add Note</h2>
<a href="Display_notes.php" class="d-block mt-3">Display Notes</a>


<div class="mt-4"><?= $output ?></div>


<form method="post">
    <label class="form-label">Date and Time</label>
    <input type="datetime-local" class="form-control" name="dateTime">

    <label class="form-label mt-3">Note</label>
    <textarea class="form-control" name="note"></textarea>

    <button class="btn btn-primary mt-3" name="submit">Add Note</button>

</form>

</body>
</html>