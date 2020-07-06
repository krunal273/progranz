<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Video extends GUI {

    public $form_data = array(
        "table" => ["video_master", "course_master", "user_master"],
        "table_alias" => ["video", "course", "u1"],
        "join_type" => ["INNER", "LEFT"],
        "join_condition" => [["course_id", "id"], ["created_by", "id"]],
        "title" => "video",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => array("col1"),
        "fields" => array(
            "pkey" => array(
                "field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ),
            "video" => [
                "title" => "video",
                "field" => "video",
                "type" => "file",
                "validation" => ["required" => "required"],
                "allowed_formats" => ["mp4", "mkv", "avi", "mov", "3gp"],
                //"hide_table" => "",
                "preview" => "video"
            ],
            "course_id" => ["title" => "course",
                "field" => "course_id",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col3" => ["title" => "course",
                "table" => 1,
                "field" => "course_id",
                "foreign_field" => "name",
                "condition" => " AND category_id = 2 ",
                "type" => "select",
                "validation" => ["required" => "required"]
            ],
            "col1" => array(
                "title" => "title",
                "field" => "title",
                "type" => "text",
                "transform" => "capitalize",
                "validation" => array("required" => "required")
            ),
            "col2" => array(
                "title" => "description",
                "field" => "description",
                "type" => "textarea",
                "transform" => "capitalize",
                "validation" => array("required" => "required")
            ),
            "act" => ["field" => "active",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "c_by" => [
                "title" => "created by",
                "table" => 2,
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
        $this->form_data["fields"]["video"]["path"] = "../docs/user_{$_SESSION['uid']}/course_";
    }

    public function createFolders($id) {
        $dir = "../docs/user_" . $_SESSION['uid'];

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        if ($id !== -1) {
            $dir = "../docs/user_" . $_SESSION['uid'] . "/" . "course_" . $_POST["col3"];

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }

        $dir = "../docs/user_" . $_SESSION['uid'] . "/" . "course_" . $_POST["col3"] . "/videos";

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
    }

    public function performOperation($ids) {
        parent::performOperation($ids);

//        if ($_POST['operation'] === "harddelete") {
//            foreach ($ids as $id) {
//                $dir = "../docs/user_" . $_SESSION['uid'] . "/" . "course_" . $_POST["col3"];
//                removeDir($dir);
//            }
//        }
    }

    function uploadFiles($file_array, $id, $edit = false) {
        $this->createFolders($id["id"]);
        $path = $this->form_data["fields"]["video"]["path"] . $_POST["col3"] . "/videos/";
        $src = "";

        foreach ($file_array as $field => $file_name) {
            $tmp_name = $_FILES[$field]['tmp_name'];
//            resiseImage($field);
            move_uploaded_file($tmp_name, $path . $file_name);
            return true;
        }

//        foreach ($file_array as $field => $file_name) {
////            $tmp_name = $_FILES[$field]['tmp_name'];
////            resizeImage($field);
////            move_uploaded_file($tmp_name, $path . $file_name);
//            $filename = $_FILES[$field]['tmp_name'];
//            $img = $_POST['cropped_image'];
//            $img = str_replace('data:image/png;base64,', '', $img);
//            $img = str_replace(' ', '+', $img);
//            $data = base64_decode($img);
//            file_put_contents($path . $file_name, $data);
////            resizeImage($path . $file_name);
//            return true;
//        }
    }

//    protected function setExtraInfo($field, $object) {
//        $extra = "";
//        if ($field === "col1") {
//            $extra = [];
//            $path = $this->form_data["fields"]["video"]["path"] . $object["pkey"];
//            if ($object["video"] !== "") {
//                $extra["video"] = $path . "/" . $object["video"];
//            } else {
//                $extra["video"] = "";
//            }
//        }
//        return $extra;
//    }
}

$object = new Video();

include_once '../classes/_common.php';
