<?php
require_once "../classes/Pdo_methods.php";

/* -----------------------------------------
   READ JSON INPUT INSTEAD OF $_POST
------------------------------------------*/
$input = json_decode(file_get_contents("php://input"), true);

if (!isset($input["name"]) || trim($input["name"]) === "") {
    echo json_encode(["masterstatus" => "error", "msg" => "No name received"]);
    exit;
}

$fullName = trim($input["name"]);
$parts = explode(" ", $fullName);

/* -----------------------------------------
   VALIDATE FIRST + LAST NAME
------------------------------------------*/
if (count($parts) < 2) {
    echo json_encode(["masterstatus" => "error", "msg" => "Enter first and last name"]);
    exit;
}

$first = ucfirst(strtolower($parts[0]));
$last = ucfirst(strtolower($parts[1]));
$formatted = "$last, $first";

/* -----------------------------------------
   INSERT INTO DATABASE
------------------------------------------*/
$pdo = new PdoMethods();

$sql = "INSERT INTO names (name) VALUES (:name)";
$bindings = [
    [":name", $formatted, "str"]
];

$result = $pdo->otherBinded($sql, $bindings);

if ($result === "error") {
    echo json_encode(["masterstatus" => "error", "msg" => "Insert failed"]);
    exit;
}

echo json_encode(["masterstatus" => "success", "msg" => "Name added"]);
