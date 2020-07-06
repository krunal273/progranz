<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Category extends GUI {

    protected $form_data = [
        "table" => ["category_master"],
        "table_alias" => ["category"],
        "title" => "category",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => ["col0","col1"],
        "fields" => ["pkey" => ["field" => "id",
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
            "col1" => ["title" => "category",
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

$object = new Category();

include_once '../classes/_common.php';