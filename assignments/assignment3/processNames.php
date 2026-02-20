<?php

function addClearNames() {

    if (isset($_POST["clear"])) {
        return "";
    }

    $existingList = $_POST["namelist"];

    $namesArray = $existingList === "" ? [] : explode("\n", $existingList);

    $fullName = $_POST["fullname"];

    list($first, $last) = explode(" ", $fullName);

    $first = ucfirst(strtolower($first));
    $last  = ucfirst(strtolower($last));

    $formatted = $last . ", " . $first;

    array_push($namesArray, $formatted);

    sort($namesArray);

    return implode("\n", $namesArray);
}