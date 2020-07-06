<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class PerPage extends GUI {

    public $form_data = array(
        "table" => ["per_page_master"],
        "table_alias" => ["per_page"],
        "title" => "per_page",
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
                "title" => "page",
                "field" => "page",
                "type" => "text",
                "align" => "center",
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

$object = new PerPage();

include_once '../classes/_common.php';