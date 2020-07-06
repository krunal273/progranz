<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Quiz_answer extends GUI {

    protected $form_data = [
        "table" => ["quiz_answer_master", "quiz_question_master"],
        "table_alias" => ["quiz_answer", "quiz_question"],
        "join_type" => ["INNER"],
        "join_condition" => [["quiz_question_id", "id"]],
        "title" => "quiz_answer",
        "constraints" => ["unique" => ["col3","col0"]],
        "default_sort" => ["col3","col0"],
        "fields" => ["pkey" => ["field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col3" => [
                "title" => "quiz question",
                "table" => 1,
                "field" => "quiz_question_id",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "quiz_question",
                "type" => "select",
                "transform" => "capitalize",
                "multi" => "",
                "validation" => ["required" => "required"]
            ],
            "col0" => [
                "title" => "answer",
                "field" => "answer",
                "type" => "textarea",
                "align" => "center",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "col6" => ["title" => "is answer",
                "field" => "is_answer",
                "type" => "radio",
                "inline" => "",
                "options" => [["title" => "yes", "value" => "yes"], ["title" => "no", "value" => "no", "checked" => ""]],
                "validation" => ["required" => "required"]
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

$object = new Quiz_answer();

include_once '../classes/_common.php';
