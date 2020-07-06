<?php

include_once '../includes/config.php';
$current_page = getCurrentPage();
$current_class = getCurrentClass();

function readCode($filename) {
    $myfile = fopen("../compile_code/" . $filename, "r") or die("Unable to open file!");
    if (filesize("../compile_code/" . $filename) === 0) {
        $file_contents = "";
    } else {
        $file_contents = fread($myfile, filesize("../compile_code/" . $filename));
    }
    fclose($myfile);
    return $file_contents;
}

function br2nl($string) {
    return preg_replace("/\r\n|\n|\r/", "", $string);
}

function resiseImage($filename, $maxDimW = 200, $maxDimH = 200) {
    list($width, $height, $type, $attr) = getimagesize($_FILES[$filename]['tmp_name']);
    if ($width > $maxDimW || $height > $maxDimH) {
        $target_filename = $_FILES[$filename]['tmp_name'];
        $fn = $_FILES[$filename]['tmp_name'];
        $size = getimagesize($fn);
        $ratio = $size[0] / $size[1]; // width/height
        if ($ratio > 1) {
            $width = $maxDimW;
            $height = $maxDimH / $ratio;
        } else {
            $width = $maxDimW * $ratio;
            $height = $maxDimH;
        }
        $src = imagecreatefromstring(file_get_contents($fn));
        $dst = imagecreatetruecolor($width, $height);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $size[0], $size[1]);
        imagejpeg($dst, $target_filename); // adjust format as needed
    }
}

function renameExistingFile($path, $filename) {
    if ($_FILES[$filename]['name'] !== "") {
        $name = $_FILES[$filename]['name'];
        $actual_name = pathinfo($name, PATHINFO_FILENAME);
        $extension = pathinfo($name, PATHINFO_EXTENSION);

        $i = 1;
        while (file_exists($path . "/" . $actual_name . "." . $extension)) {
            $actual_name = (string) $actual_name . $i;
            $name = $actual_name . "." . $extension;
            $i++;
        }
        return $name;
    } else {
        return false;
    }
}

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
    if (!isset($_SESSION['uid'])) {
        header("location:../public/index.php");
    }
}

function logout() {
    logAction("login", "logout [{$_SESSION['uname']} ({$_SESSION['uid']})] ");
    session_destroy();
    session_start();
}

function setMessage($message, $type = "success") {
    return ["type" => $type,
        "message" => $message];
}

function logAction($type, $action = false, $message = "") {
    if ($action) {
        $logpath = $_SERVER['DOCUMENT_ROOT'] . '/logs/';
        $logfile = $type . ".txt";

        if (!file_exists($logpath)) {
            mkdir($logpath, 0777, true);
        }

        $new = file_exists($logpath . $logfile) ? false : true;

        if ($new) {
            $myfile = fopen($logpath . $logfile, "w", 0777);
            fclose($myfile);
        }
        if ($handle = fopen($logpath . $logfile, 'a')) { // append
            $timestamp = strftime("%Y-%m-%d %H:%M:%S", time());
            if ($message !== "") {
                $message = " : {$message}";
            }
            $content = "{$timestamp} | {$action}{$message}\n";
            fwrite($handle, $content);
            fclose($handle);
        } else {
            echo "Could not open log file for writing.";
        }
    }
}

function appStatus($status = "") {
    $app_file = $_SERVER['DOCUMENT_ROOT'] . '/status.txt';
    switch ($status) {
        case "":
            if (file_exists($app_file)) {
                $handle = @fopen($app_file, "r");
                if ($handle) {
                    while (($buffer = fgets($handle, 4096)) !== false) {
                        return $buffer;
                    }
                    fclose($handle);
                }
            } else {
                $handle = fopen($app_file, 'w', 0777);
            }
            break;
        case "1":
        case "0":
            $handle = fopen($app_file, 'w', 0777);
            fwrite($handle, $status);
            fclose($handle);
            break;
    }
}

function isValidIP($ip, $status = "") {
    $app_file = $_SERVER['DOCUMENT_ROOT'] . '/ip.txt';
    switch ($status) {
        case "":
            if (file_exists($app_file)) {
                $handle = @fopen($app_file, "r");
                if ($handle) {
                    while (($buffer = fgets($handle, 4096)) !== false) {
                        return $buffer;
                    }
                    fclose($handle);
                }
            } else {
                $handle = fopen($app_file, 'w', 0777);
            }
            break;
        case true:
        case false:
            $handle = fopen($app_file, 'w', 0777);
            fwrite($handle, $status);
            fclose($handle);
            break;
    }
}

function generateRandomString($length = 100) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

function rangeWeek($datestr) {
    date_default_timezone_set(date_default_timezone_get());
    $dt = strtotime($datestr);
    $res['start'] = date('N', $dt) == 1 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('last monday', $dt));
    $res['end'] = date('N', $dt) == 7 ? date('Y-m-d', $dt) : date('Y-m-d', strtotime('next sunday', $dt));
    return $res;
}

function rangeMonth($datestr) {
    date_default_timezone_set(date_default_timezone_get());
    $dt = strtotime($datestr);
    $res['start'] = date('Y-m-d', strtotime('first day of this month', $dt));
    $res['end'] = date('Y-m-d', strtotime('last day of this month', $dt));
    return $res;
}

function rangeYear() {
    date_default_timezone_set(date_default_timezone_get());
    $res['start'] = date('Y-m-d', strtotime(date('Y-01-01')));
    $res['end'] = date('Y-m-d', strtotime('Dec 31'));
    return $res;
}

if (isset($_POST["operation"])) {
    if ($_POST["operation"] === "logout") {
        $message = setMessage("successfully logged out");
        logout();
        $_SESSION["messagebag"][] = $message;
        echo json_encode($message);
    }
} else if (isset($_POST["app"])) {
    appStatus("0");
    echo json_encode(["disabled" => true]);
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
