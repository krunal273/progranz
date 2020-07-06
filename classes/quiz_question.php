<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Quiz_question extends GUI {

    protected $form_data = [
        "table" => ["quiz_question_master", "quiz_master"],
        "table_alias" => ["quiz_question", "quiz"],
        "join_type" => ["INNER"],
        "join_condition" => [["quiz_id", "id"]],
        "title" => "quiz_question",
        "constraints" => ["unique" => ["col3","col1"]],
        "default_sort" => ["col3","col1"],
        "fields" => ["pkey" => ["field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col3" => [
                "title" => "quiz",
                "table" => 1,
                "field" => "quiz_id",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "quiz",
                "type" => "select",
                "transform" => "capitalize",
                "multi" => "",
                "validation" => ["required" => "required"]
            ],
            "col1" => [
                "title" => "question",
                "field" => "name",
                "type" => "textarea",
                "align" => "center",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "col2" => ["title" => "mark",
                "field" => "mark",
                "type" => "text",
                "transform" => "lowercase",
                "validation" => ["required" => "required", "min" => 1, "max" => 3]
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
    }

}

$object = new Quiz_question();

include_once '../classes/_common.php';
