<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Usertype extends GUI {

    public $form_data = array(
        "table" => ["usertype_master", "user_master", "module_master"],
        "table_alias" => ["utype", "u1", "u2"],
        "join_type" => ["LEFT", "LEFT"],
        "join_condition" => [["created_by", "id"], ["updated_by", "id"]],
        "title" => "usertype",
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
                "title" => "usertype",
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
            ),
            "c_by" => [
                "title" => "created by",
                "table" => 1,
                "field" => "created_by",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "user",
                "type" => "select",
                "multi" => "",
                "validation" => ["required" => "required"],
                "hide_form" => "",
                "has_null" => "",
                "hidden" => "",
            ],
            "u_by" => [
                "title" => "updated by",
                "table" => 2,
                "field" => "updated_by",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "user",
                "type" => "select",
                "multi" => "",
                "validation" => ["required" => "required"],
                "has_default" => "",
                "hide_form" => "",
                "has_null" => "",
                "hidden" => "",
            ],
            "c_date" => [
                "title" => "created date",
                "field" => "created_date",
                "type" => "datetime",
//                "align" => "center",
//                "format" => "DD-MM-Y",
//                "hideToday" => "",
                "input_class" => "col-sm-5",
                "transform" => "capitalize",
                "hide_form" => "",
                "hidden" => ""
            ],
            "u_date" => [
                "title" => "updated date",
                "field" => "updated_date",
                "type" => "datetime",
                "align" => "center",
                "transform" => "uppercase",
                "has_default" => "",
                "hide_form" => "",
                "has_null" => "",
                "hidden" => ""
            ]
        )
    );

    public function __construct() {
        parent::__construct();
        if (isset($_SESSION['utype'])) {
            $this->operations["delete"]["condition"] = [
                ["field" => "pkey", "operation" => "!=", "value" => $_SESSION['utype']]
            ];
            $this->operations["deactivate"]["condition"] = [
                ["field" => "pkey", "operation" => "!=", "value" => $_SESSION['utype']]
            ];
        }
    }

}

$object = new Usertype();

include_once '../classes/_common.php';
