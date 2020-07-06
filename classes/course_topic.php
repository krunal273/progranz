<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Course_topic extends GUI {

    public $form_data = array(
        "table" => ["course_topic_master", "course_master"],
        "table_alias" => ["course_topic", "course"],
        "join_type" => ["INNER"],
        "join_condition" => [["course_id", "id"]],
        "title" => "course",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => array("col2","col3"),
        "fields" => array(
            "pkey" => array(
                "field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ),
            "col2" => array(
                "title" => "sequence",
                "field" => "sequence",
                "type" => "text",
                "transform" => "capitalize",
                "validation" => array("required" => "required")
            ),
            "col3" => ["title" => "course",
                "table" => 1,
                "field" => "course_id",
                "foreign_field" => "name",
                "type" => "select",
                "validation" => ["required" => "required"]
            ],
            "col1" => array(
                "title" => "topic name",
                "field" => "name",
                "type" => "text",
                "transform" => "capitalize",
                "validation" => array("required" => "required")
            ),
            "col4" => ["title" => "filename",
                "field" => "filename",
                "transform" => "lowercase",
                "type" => "text",
                "validation" => ["required" => "required"]
            ],
            "act" => ["field" => "active",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ]
        )
    );

    public function __construct() {
        parent::__construct();
    }

}

$object = new Course_topic();

include_once '../classes/_common.php';
