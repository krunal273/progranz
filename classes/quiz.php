<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Quiz extends GUI {

    protected $form_data = [
        "table" => ["quiz_master"],
        "table_alias" => ["quiz"],
        "title" => "quiz",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => ["col1", "col2"],
        "fields" => ["pkey" => ["field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col1" => [
                "title" => "name",
                "field" => "name",
                "type" => "text",
                "align" => "center",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "col2" => ["title" => "time",
                "field" => "time",
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
        $extra_operation = ["title" => "grid",
            "color" => "info",
            "class" => "grid_operation",
            "visibility" => "hidden-xs hidden-sm hidden-md hidden-lg",
            "icon" => "th",
            "always_visible" => "",
            "category_only" => "",
            "icon_class" => "",
            "data" => ["title" => "operation", "value" => "grid_operation"]
        ];

        $this->operations["grid"] = $extra_operation;

        $this->categories["active"]["show"][] = "grid";
        parent::__construct();
        $this->t_w = "col-md-6";
    }

    public function getAnswers() {
        $answers = [];
        foreach ($_POST['questions'] as $question) {
            $query = "SELECT id FROM quiz_answer_master WHERE quiz_question_id = {$question} AND is_answer = 'yes' ";
            $result = $this->find_by_sql($query);
            if (empty($result)) {
                $answers[] = "-1";
            } else {
                $result = array_shift($result);
                $answers[] = $result["id"];
            }
        }
        
        return $answers;
    }

}

$object = new Quiz();

include_once '../classes/_common.php';

if (isset($_POST["questions"])) {
    echo json_encode($object->getAnswers());
}
