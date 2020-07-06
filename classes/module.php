<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Module extends GUI {

    protected $form_data = [
        "table" => ["module_master"],
        "table_alias" => ["module"],
        "title" => "module",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => ["col1"],
        "fields" => [
            "pkey" => ["field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col1" => [
                "title" => "module",
                "field" => "name",
                "type" => "text",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "col3" => [
                "title" => "display name",
                "field" => "display_name",
                "type" => "text",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "col2" => ["title" => "dev only",
                "field" => "dev_only",
                "type" => "radio",
                "inline" => "",
                "options" => [
                    ["title" => "yes", "value" => "1"],
                    ["title" => "no", "value" => "0", "checked" => ""]],
                "validation" => ["required" => "required"]
            ],
            "act" => [
                "field" => "active",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ]
        ]
    ];

    public function __construct() {
        parent::__construct();
        $this->t_w = "col-md-6";
    }
}

$object = new Module();

include_once '../classes/_common.php';