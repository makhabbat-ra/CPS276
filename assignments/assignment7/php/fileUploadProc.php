<?php

require_once 'classes/Db_conn.php';
require_once 'classes/Pdo_methods.php';

$output = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $filename = trim($_POST["fileName"]);   
    $file = $_FILES["file"];                

    if ($filename == "") {
        $output = "<p style='color:red;'>Please enter a file name.</p>";
    }
    else if ($file["error"] !== 0) {
        $output = "<p style='color:red;'>Error uploading file.</p>";
    }
    else if ($file["size"] > 100000) {
        $output = "<p style='color:red;'>File is too large. Must be under 100000 bytes.</p>";
    }
    else if ($file["type"] !== "application/pdf") {
        $output = "<p style='color:red;'>File must be a PDF.</p>";
    }
    else {

        $serverPath = "/home/m/r/mrakhymbekova/public_html/cps276/assignments/assignment7/files/" . basename($file["name"]);
        $urlPath = "files/" . basename($file["name"]);

        if (!move_uploaded_file($file["tmp_name"], $serverPath)) {
            $output = "<p style='color:red;'>Could not move uploaded file.</p>";
        }
        else {
            $pdo = new PdoMethods();
            $sql = "INSERT INTO uploaded_files (filename, filepath) VALUES (:filename, :filepath)";
            $bindings = [
                [":filename", $filename, "str"],
                [":filepath", $urlPath, "str"]
            ];

            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === "error") {
                $output = "<p style='color:red;'>Database error.</p>";
            } 
            else {
                $output = "<p style='color:green;'>File has been added</p>";
            }
        }
    }
}
?>