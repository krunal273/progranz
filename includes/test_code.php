<?php
include_once '../includes/functions.php';

if (isset($_POST['test'])) {
    $code = $_POST['code'];
    $filename = $_POST["filename"];
    $myfile = fopen("../try/" . $filename, "w") or die("Unable to open file!");
    fwrite($myfile, $code);
    fclose($myfile);
    echo json_encode(setMessage("code copied"));
} else {
    echo json_encode(setMessage("code copy error", "danger"));
}