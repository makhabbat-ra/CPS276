<?php
require_once 'classes/Date_time.php';
$dt = new Date_time();
$output = $dt->displayNotes();
?>
<!DOCTYPE html>
<html>
<head>
<title>Display Notes</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-4">

<h2>Display Notes</h2>
<a href="index.php" class="d-block mt-3">Add Notes</a>
<form method="post">
    <label class="form-label">Beginning Date</label>
    <input type="date" class="form-control" name="begDate">

    <label class="form-label mt-3">Ending Date</label>
    <input type="date" class="form-control" name="endDate">

    <button class="btn btn-primary mt-3" name="getNotes">Get Notes</button>

    
</form>

<!-- OUTPUT MOVED HERE, NOT BOLD -->
<div class="mt-4">
    <?= $output ?>
</div>

</body>
</html>