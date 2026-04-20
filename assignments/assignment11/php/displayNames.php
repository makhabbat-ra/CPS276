<?php
require_once "../classes/Pdo_methods.php";

$pdo = new PdoMethods();

/* -----------------------------------------
   GET ALL NAMES FROM DATABASE
------------------------------------------*/
$sql = "SELECT name FROM names ORDER BY name ASC";
$records = $pdo->selectNotBinded($sql);

/* -----------------------------------------
   DATABASE ERROR
------------------------------------------*/
if ($records === "error") {
    echo json_encode([
        "masterstatus" => "error",
        "msg" => "Could not retrieve names"
    ]);
    exit;
}

/* -----------------------------------------
   NO NAMES IN DATABASE
------------------------------------------*/
if (count($records) === 0) {
    echo json_encode([
        "masterstatus" => "success",
        "names" => "<p>No names to display</p>"
    ]);
    exit;
}

/* -----------------------------------------
   BUILD OUTPUT LIST
------------------------------------------*/
$output = "";
foreach ($records as $row) {
    $output .= "<p>{$row['name']}</p>";
}

/* -----------------------------------------
   RETURN SUCCESS + NAME LIST
------------------------------------------*/
echo json_encode([
    "masterstatus" => "success",
    "names" => $output
]);
