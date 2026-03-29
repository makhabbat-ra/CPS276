<?php
require_once 'classes/Db_conn.php';
require_once 'classes/Pdo_methods.php';

$output = "";

$pdo = new PdoMethods();
$sql = "SELECT filename, filepath FROM uploaded_files";
$records = $pdo->selectNotBinded($sql);

if ($records == "error") {
    $output = "<p style='color:red;'>Database error.</p>";
    return;
}

if (count($records) == 0) {
    $output = "<p>No files uploaded yet.</p>";
    return;
}

$output = "<ul>";

foreach ($records as $row) {
    $file = $row["filepath"];
    $name = $row["filename"];

    $output .= "<li><a target='_blank' href='$file'>$name</a></li>";
}

$output .= "</ul>";
?>