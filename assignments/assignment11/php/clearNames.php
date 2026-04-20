<?php
require_once "../classes/Pdo_methods.php";

$pdo = new PdoMethods();

$sql = "DELETE FROM names";

$result = $pdo->otherNotBinded($sql);

if ($result === "error") {
    echo json_encode(["status" => "error", "message" => "Clear failed"]);
    exit;
}

echo json_encode(["status" => "success"]);
