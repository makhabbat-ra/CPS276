<?php
require_once 'Db_conn.php';
require_once 'Pdo_methods.php';

class Date_time {

    /* -------------------------
       ADD NOTE PAGE PROCESSING
       ------------------------- */
    public function addNote() {

        if (!isset($_POST['submit'])) return "";

        $date = $_POST['dateTime'] ?? "";
        $note = trim($_POST['note'] ?? "");

        if ($date === "" || $note === "") {
            return "You must enter a date, time, and note.";
        }

        // Convert datetime-local to timestamp
        $timestamp = strtotime($date);

        $pdo = new PdoMethods();
        $sql = "INSERT INTO notes (date_time, note) VALUES (:dt, :note)";
        $bindings = [
            [":dt", $timestamp, "int"],
            [":note", $note, "str"]
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if ($result === "error") {
            return "There was an error adding the note.";
        }

        return "Note successfully added.";
    }



    /* -------------------------
       DISPLAY NOTES PAGE
       ------------------------- */
    public function displayNotes() {

        if (!isset($_POST['getNotes'])) return "";

        $beg = $_POST['begDate'] ?? "";
        $end = $_POST['endDate'] ?? "";

        if ($beg === "" || $end === "") {
            return "No notes found for the date range selected";
        }

        // Convert to timestamps
        $begTS = strtotime($beg . " 00:00:00");
        $endTS = strtotime($end . " 23:59:59");

        $pdo = new PdoMethods();
        $sql = "SELECT date_time, note FROM notes 
                WHERE date_time BETWEEN :beg AND :end 
                ORDER BY date_time DESC";

        $bindings = [
            [":beg", $begTS, "int"],
            [":end", $endTS, "int"]
        ];

        $records = $pdo->selectBinded($sql, $bindings);

        if ($records === "error" || count($records) === 0) {
            return "No notes found for the date range selected";
        }

        // Build table
        $output = "<table class='table table-bordered mt-3'>
                    <tr><th>Date</th><th>Note</th></tr>";

        foreach ($records as $row) {
            $dateFormatted = date("m/d/Y h:i A", $row['date_time']);
            $output .= "<tr>
                            <td>{$dateFormatted}</td>
                            <td>{$row['note']}</td>
                        </tr>";
        }

        $output .= "</table>";

        return $output;
    }
}