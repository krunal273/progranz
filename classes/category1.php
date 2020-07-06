<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Category1 extends GUI {

    protected $form_data = [
        "table" => ["category1_master"],
        "table_alias" => ["category1"],
        "title" => "category1",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => ["col1"],
        "fields" => ["pkey" => ["field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col1" => ["title" => "category1",
                "field" => "name",
                "type" => "text",
                "transform" => "lowercase",
                "validation" => ["required" => "required", "min" => 1, "max" => 20]
            ],
            "act" => ["field" => "active",
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

$object = new Category1();

include_once '../classes/_common.php';