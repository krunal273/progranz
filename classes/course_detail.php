<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Course_detail extends GUI {

    public function __construct() {
        parent::__construct();
    }

    public function getFiles() {
        $files = getFiles($_GET["path"] . $_GET["folder"]);
        return $files;
    }

}

$object = new Course_detail();

if (isset($_GET["path"])) {
    echo json_encode($object->getFiles());
}
