<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Tag extends GUI {

    public $form_data = array(
        "table" => ["tag_master"],
        "table_alias" => ["tag"],
        "title" => "tag",
        "constraints" => array("unique" => array("col1")),
        "default_sort" => array("col1"),
        "fields" => array(
            "pkey" => array(
                "field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ),
            "col1" => array(
                "title" => "tag",
                "field" => "name",
                "type" => "text",
                "transform" => "capitalize",
                "validation" => array("required" => "required")
            ),
            "act" => array(
                "field" => "active",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            )
        )
    );

    public function __construct() {
        parent::__construct();
    }

}

$object = new Tag();

include_once '../classes/_common.php';

if (isset($_GET['get_tags'])) {
    $append = "";
    if(isset($_GET['ta'])){
        $append = " AND name like '%{$_GET['get_tags']}%' ";
    }
    $query = "SELECT id, name FROM tag_master WHERE active = 1 {$append} ORDER BY name";
    $result = $object->find_by_sql($query);
    echo json_encode($result);
}