<?php

require_once('../includes/functions.php');
require_once('../classes/_database.php');
require_once('../classes/_gui.php');

class Module_operation extends GUI {

    protected $form_data = [
        "table" => ["module_operation_master", "module_master", "operation_master", "user_master", "user_master"],
        "table_alias" => ["module_operation", "module", "operation", "u1", "u2"],
        "join_type" => ["INNER", "INNER", "LEFT", "LEFT"],
        "join_condition" => [["module_id", "id"], ["operation_id", "id"], ["created_by", "id"], ["updated_by", "id"]],
        "title" => "module_operation",
        "constraints" => ["unique" => ["col1","col2"]],
        "default_sort" => ["col1","col3"],
        "fields" => [
            "pkey" => [
                "field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col1" => [
                "title" => "module",
                "table" => 1,
                "field" => "module_id",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "module",
                "type" => "select",
                "transform" => "capitalize",
                "multi" => "",
                "validation" => ["required" => "required"]
            ],
            "col2" => [
                "title" => "operation",
                "table" => 2,
                "field" => "operation_id",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "operation",
                "type" => "select",
                "transform" => "capitalize",
                "multi" => "",
                "validation" => ["required" => "required"]
            ],
            "col3" => [
                "title" => "sequence",
                "table" => 2,
                "field" => "other",
                "foreign_field" => "sequence",
                "foreign_non_id" => "",
                "type" => "text",
                "hide_form" => ""
            ],
            "act" => ["field" => "active",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "c_by" => [
                "title" => "created by",
                "table" => 3,
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
                "table" => 4,
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
                "align" => "center",
                "transform" => "uppercase",
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
        ]
    ];

    public function __construct() {
        parent::__construct();
    }
}

$object = new Module_operation();

include_once '../classes/_common.php';
