<?php

include_once '../includes/config.php';
include_once '../includes/functions.php';
include_once '../classes/_database.php';
if (isset($_GET['activation_key'])) {
    activateUser($_GET['email'], $_GET['activation_key']);
    header("location:../public/index.php");
}

function activateUser($email, $key) {
    $database = new Database();
    $query = "UPDATE user_master set email_verified = 1, activation_key = NULL, active=1 WHERE email = '{$email}' AND activation_key ='{$key}'";
    $result = $database->query($query);

    if ($database->affected_rows() > 0) {
        $_SESSION['messagebag'][] = setMessage("User activated successfully", "success");
    } else {
        $_SESSION['messagebag'][] = setMessage("No user found for activation", "danger");
    }
}


