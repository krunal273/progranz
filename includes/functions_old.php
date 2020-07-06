<?php

include_once '../includes/config.php';
$current_page = getCurrentPage();
$current_class = getCurrentClass();

function displayMessages() {
    if (isset($_SESSION['messagebag'])) {
        echo "<script>";
        foreach ($_SESSION['messagebag'] as $message) {
            $message = setMessage($message['message'], $message['type']);
            echo " var json_ob = JSON.parse('" . json_encode($message) . "');";
            echo " showAlert(json_ob);";
        }
        echo "</script>";
        unset($_SESSION['messagebag']);
    }
}

function getCurrentPage() {
    $current_page = explode('/', $_SERVER['PHP_SELF']);
    $current_page = $current_page[count($current_page) - 1];
    return $current_page;
}

function getCurrentClass() {
    $current_class = explode('/', $_SERVER['PHP_SELF']);
    $current_class = $current_class[count($current_class) - 1];

    $current_class = explode('.', $current_class);
    $current_class = $current_class[0];

    return $current_class;
}

function printSearch() {
    echo "<div class='input-group'>" .
    "<input type='text' class='form-control' placeholder='Search'>" .
    "<div class='input-group-btn'>" .
    "<button class='btn btn-default' type='submit'>" .
    "<i class='glyphicon glyphicon-search'>" .
    "</i>" .
    "</button>" .
    "</div>" .
    "</div>";
}

function checkLogin() {
//    if (!isset($_SESSION['uid'])) {
//        header("location:../public/index.php");
//    }
}

function logout() {
    logAction("login", "logout [{$_SESSION['uname']} ({$_SESSION['uid']})] ");
    session_destroy();
    session_start();
}

function setMessage($message, $type = "success") {
    return array("type" => $type,
        "message" => $message);
}

function logAction($type, $action = false, $message = "") {
//    if ($action) {
//        $logpath = $_SERVER['DOCUMENT_ROOT'] . '/logs/';
//        $logfile = $type.".txt";
//        if (!file_exists($logpath)) {
//            mkdir($logpath, 0777, true);
//        }
//
//        $new = file_exists($logpath . $logfile) ? false : true;
//        
//        if ($new) {
//            $myfile = fopen($logpath . $logfile, "w");
//            fclose($myfile);
//            chmod($logfile, 0755);
//        }
//        if ($handle = fopen($logpath . $logfile, 'a')) { // append
//            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
//            if($message !== ""){
//                $message = " : {$message}";
//            }
//            $content = "{$timestamp} | {$action}{$message}\n";
//            fwrite($handle, $content);
//            fclose($handle);
//        } else {
//            echo "Could not open log file for writing.";
//        }
//    }
}

if (isset($_POST["operation"])) {
    if ($_POST["operation"] === "logout") {
        logout();
        $message = setMessage("successfully logout");
        $_SESSION["messagebag"][] = $message;
        echo json_encode($message);
    }
}

function removeDir($dir) {
    $files = array_diff(scandir($dir), array('.', '..'));
    foreach ($files as $file) {
        (is_dir("$dir/$file")) ? removeDir("$dir/$file") : unlink("$dir/$file");
    }
    return rmdir($dir);
}

function getFiles($path) {
    $files = [];
    if (!file_exists($path))
        mkdir($path);
    $dh = opendir($path);
    while (false !== ($filename = readdir($dh))) {
        if ($filename != "." && $filename != "..") {
            if (is_dir($path . "/" . $filename)) {
                $files[$filename] = getFiles($path . "/" . $filename);
            } else {
                $files[] = $filename;
            }
        }
    }
    return $files;
}
