<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Operations extends GUI {

    protected $form_data = [
        "table" => ["operation_master"],
        "table_alias" => ["operation"],
        "title" => "operation",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => ["col0","col2", "col1"],
        "fields" =>
        ["pkey" => [
                "field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col0" => [
                "title" => "sequence",
                "field" => "sequence",
                "type" => "text",
                "align" => "center",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "col1" => [
                "title" => "operation",
                "field" => "name",
                "type" => "text",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "col2" => [
                "title" => "common",
                "field" => "common",
                "type" => "radio",
                "inline" => "",
                "options" => [
                    ["title" => "common", "value" => "common", "checked" => ""],
                    ["title" => "specific", "value" => "specific"]
                ],
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

$object = new Operations();

include_once '../classes/_common.php';
