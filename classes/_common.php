<?php

if (isset($_GET['operation'])) {
    if (isset($_GET['search'])) {
        if ($_GET['search'] === "") {
            unset($_GET['search']);
        }
    }
    switch ($_GET['operation']) {
        case "gui":
            if (isset($_GET['date_filter'])) {
                unset($_SESSION["sessions"][$object->current_page]['datebox']);
                switch ($_GET["date_filter"]) {
                    case "remove_search":
                        break;
                    case "custom_date":
                        $_SESSION["sessions"][$object->current_page]['datebox'] = [];
                        foreach ($_GET['date_fields'] as $date_field) {
                            $_SESSION["sessions"][$object->current_page]['datebox'][$date_field]['date_filter'] = $_GET['date_filter'];
                            $_SESSION["sessions"][$object->current_page]['datebox'][$date_field]["start_date"] = date("Y-m-d", strtotime($_GET["start_date"]));
                        }
                        break;
                    case "custom_range":
                        $_SESSION["sessions"][$object->current_page]['datebox'] = [];
                        foreach ($_GET['date_fields'] as $date_field) {
                            $_SESSION["sessions"][$object->current_page]['datebox'][$date_field]['date_filter'] = $_GET['date_filter'];
                            $_SESSION["sessions"][$object->current_page]['datebox'][$date_field]["start_date"] = date("Y-m-d", strtotime($_GET["start_date"]));
                            if (isset($_GET['end_date'])) {
                                $_SESSION["sessions"][$object->current_page]['datebox'][$date_field]["end_date"] = date("Y-m-d", strtotime($_GET["end_date"]));
                            }
                        }
                        break;
                    default :
                        $_SESSION["sessions"][$object->current_page]['datebox'] = [];
                        foreach ($_GET['date_fields'] as $date_field) {
                            $_SESSION["sessions"][$object->current_page]['datebox'][$date_field]['date_filter'] = $_GET['date_filter'];
                        }
                        break;
                }
            } else if (isset($_GET['filters'])) {
                if ($_GET['filters'] !== "") {
                    $filters = json_decode($_GET['filters'], true);
                    foreach ($filters as $filter => $value) {
                        $_GET[$filter] = $value;
                    }
                }
            }
            echo json_encode($object->prepareGUI());
            break;
        case "display" :
            if ($_GET['display'] !== "") {
                $_SESSION["sessions"][$object->current_page]['operations'] = $_GET['display'];
            }
            if ($_GET['hide'] !== "") {
                $_SESSION["sessions"][$object->current_page]['hide'] = $_GET['hide'];
            }
            echo json_encode(setMessage("set"));
            break;
        case "asearch":
            $_SESSION["sessions"][$object->current_page]['asearch'] = $_GET['asearch'];
            echo json_encode($object->prepareGUI());
            break;
        case "pdf":
        case "excel":
            if (in_array($_GET['operation'], $_SESSION['permitted_operation'][$object->current_page])) {
                $file_data = $object->getFileData();
                include_once "../classes/_" . strtolower($_GET['operation']) . ".php";
            } else {
                $message = ["type" => "danger", "message" => "Operation not allowed"];
                $_SESSION["messagebag"] = $message;
                header("location:../public/".$current_page);
            }
            break;
    }
}

if (isset($_POST['operation'])) {
    switch ($_POST['operation']) {
        case "form":
            if (in_array("edit", $_SESSION['permitted_operation'][$object->current_page])) {
                $object->getForm();
            } else {
                $message = ["type" => "danger", "message" => "Operation not allowed"];
                echo json_encode($message);
            }
            break;
        case "insert":
            if (in_array("add", $_SESSION['permitted_operation'][$object->current_page])) {
                $object->insertData();
            } else {
                $message = ["type" => "danger", "message" => "Operation not allowed"];
                echo json_encode($message);
            }
            break;
        case "edit":
            if (in_array("edit", $_SESSION['permitted_operation'][$object->current_page])) {
                $object->editData();
            } else {
                $message = ["type" => "danger", "message" => "Operation not allowed"];
                echo json_encode($message);
            }
            break;
        case "delete":
        case "activate":
        case "deactivate":
        case "destroy":
        case "restore":
        case "harddelete":
            if (in_array($_POST['operation'], $_SESSION['permitted_operation'][$object->current_page])) {
                $object->performOperation($_POST['ids']);
            } else {
                $message = ["type" => "danger", "message" => "Operation not allowed"];
                echo json_encode($message);
            }

            break;
        case "set_filter":
            switch ($_POST['filter']) {
                case "multi":
                    $object->setMultiFilter();
                    break;
                case "header":
                    $object->setHeaderFilter();
                    break;
                case "search":
                    $object->setSearchFilter();
                    break;
            }
            break;
        case "remove_filter":
            switch ($_POST['filter']) {
                case "multi":
                    $object->removeMultiFilter();
                    break;
            }
            break;
    }
}