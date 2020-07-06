<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";
include_once '../libraries/getID3/getid3/getid3.php';

class Courses extends GUI {

    public $playtimes = [];
    public $rating = [];
    public $view = [];
    public $form_data = array(
        "table" => ["course_master", "category1_master", "user_master"],
        "table_alias" => ["course", "category1", "u1"],
        "join_type" => ["INNER", "LEFT"],
        "join_condition" => [["category_id", "id"], ["created_by", "id"]],
        "title" => "course",
        "constraints" => ["unique" => ["col1"]],
        "default_sort" => array("col1"),
        "fields" => array(
            "pkey" => array(
                "field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ),
            "image" => [
                "title" => "select image",
                "field" => "image",
                "type" => "file",
                "validation" => ["required" => "required"],
                "allowed_formats" => ["jpg", "jpeg", "png"],
                "hide_table" => "",
                "preview" => "image"
            ],
            "col1" => array(
                "title" => "title",
                "field" => "name",
                "type" => "text",
                "transform" => "capitalize",
                "validation" => array("required" => "required")
            ),
            "col1_1" => array(
                "title" => "folder",
                "field" => "folder",
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
            "col3" => ["title" => "category",
                "table" => 1,
                "field" => "category_id",
                "foreign_field" => "name",
                "type" => "select",
                "validation" => ["required" => "required"]
            ],
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
                "has_null" => ""
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
            ],
            "col_view" => array(
                "title" => "view",
                "field" => "view",
                "type" => "text",
                "transform" => "capitalize",
                "validation" => array("required" => "required"),
                "hide_form" => "",
            )
        )
    );

    public function categoryCount(&$category, $pagination = false) {
        $fields = $this->getFields();

        //create active condition query
        $query_condition = [];
        if (isset($category['condition'])) {
            if (is_array($category['condition'])) {
                foreach ($category['condition'] as $condition) {
                    $query_condition[] = $this->form_data["table_alias"][0] . ".active='{$condition}'";
                }
                $query_condition = "(" . implode(" OR ", $query_condition) . ")";
            } else {
                $query_condition = $this->form_data["table_alias"][0] . ".active='" . $category['condition'] . "'";
            }

            for ($i = 1; $i < count($this->form_data["table_alias"]); $i++) {
                $query_condition .= " AND " . $this->form_data["table_alias"][$i] . ".active = 1 ";
            }

            $query_condition = "WHERE {$query_condition}";
        }

        //create sort query
        if (count($_SESSION["sessions"][$this->current_page]['sort'])) {
            $sort_order = [];
            foreach ($_SESSION["sessions"][$this->current_page]["sort"] as $sort_field) {
                $sort_order[] = "{$sort_field} {$_SESSION["sessions"][$this->current_page]['order'][$sort_field]}";
            }
            $sort_query = " ORDER BY " . implode(",", $sort_order);
        } else {
            $sort_query = "";
        }

        $search_query = "";

        if ($_SESSION["sessions"][$this->current_page]['search'] !== '') {
            $search_query = $this->getSearchQuery();
        }

        if ($pagination) {
            //create pagination query
            if ($_SESSION["sessions"][$this->current_page]['per_page'] !== 'all') {
                $pagination = "LIMIT {$_SESSION["sessions"][$this->current_page]['per_page']} OFFSET " . ($_SESSION["sessions"][$this->current_page]['current_page'] * $_SESSION["sessions"][$this->current_page]['per_page']);
            } else {
                $pagination = "";
            }
        } else {
            $pagination = "";
        }

        //join condition
        $join = "";
        if (isset($this->form_data['join'])) {
            $join = " AND " . $this->form_data['join'];
        }


        //create full query
//        if(isset($_GET['tags'])){
//            $_SESSION["sessions"][$this->current_page] = $_GET['tags'];
//        }

        if (isset($_GET['tags'])) {
//        if (isset($_SESSION["sessions"][$this->current_page]['tags'])) {
            $tags = [];
//            foreach ($_SESSION["sessions"][$this->current_page]['tags'] as $tag) {
            foreach ($_GET['tags'] as $tag) {
                $tags[] = " tag_master.id = {$tag}";
            }
            $tags = implode($tags, " OR ");
            $query = "SELECT DISTINCT {$fields} FROM " . $this->getTables() . ",tag_master, course_tag_master " .
                    " {$query_condition} {$search_query} {$join} AND " .
                    " tag_master.id = course_tag_master.tag_id AND " .
                    " course.id = course_tag_master.course_id AND " .
                    "(" . $tags . ")" .
                    " {$sort_query} {$pagination}";
        } else {
            $query = "SELECT {$fields} FROM " . $this->getTables() . " " .
                    " {$query_condition} {$search_query} {$join} " .
                    " {$sort_query} {$pagination}";
        }
        $objects = $this->find_by_sql($query);
        $category["count"] = count($objects);
        $this->playtimes = [];
        foreach ($objects as $ob => $value) {
            if ($value['col3'] === "video") {
                $query = "SELECT * FROM video_master WHERE course_id = {$value['pkey']}";
                $result = $this->find_by_sql($query);
                $video_path = "../docs/user_{$result[0]['created_by']}/course_{$value['pkey']}/videos/";
                $getID3 = new getID3;
                $hours = 0;
                $minutes = 0;
                $seconds = 0;
                foreach ($result as $videos) {
                    $video_file = $video_path . $videos['video'];
                    $ThisFileInfo = $getID3->analyze($video_file);
                    getid3_lib::CopyTagsToComments($ThisFileInfo);
                    $play_time = $ThisFileInfo['playtime_string'];
                    $this->addPlayTime($play_time, $hours, $minutes, $seconds);
                }
                $this->playtimes[$value['pkey']]["hours"] = $hours;
                $this->playtimes[$value['pkey']]["minutes"] = $minutes;
                $this->playtimes[$value['pkey']]["seconds"] = $seconds;
            }

            $rating = $this->getRating($value['pkey']);
            $this->rating[$value['pkey']] = $rating;
            $this->view[$value['pkey']] = $value['col_view'];
        }

        return $objects;
    }

    public function getRating($id) {
        $query_rating = "SELECT COALESCE(AVG(rating),0) AS rating FROM review_master WHERE course_id = {$id}";
        $rating = $this->find_by_sql($query_rating);
        if (!empty($rating)) {
            $rating = $rating[0]["rating"];
        } else {
            $rating = "0";
        }
        return $rating;
    }

    public function addPlayTime($play_time, &$hours, &$minutes, &$seconds) {
        $play_time = explode(":", $play_time);

        if (count($play_time) === 3) {
            $hours = $play_time[0] + $hours;
            $minutes = $play_time[1] + $minutes;
            $seconds = $play_time[2] + $seconds;
        } else if (count($play_time) === 2) {
            $minutes = $play_time[0] + $minutes;
            $seconds = $play_time[1] + $seconds;
        } else if (count($play_time) === 1) {
            $seconds = $play_time[0] + $seconds;
        }

        if ($seconds > 60) {
            $minutes += intval($seconds / 60);
            $seconds = $seconds % 60;
        }

        if ($minutes > 60) {
            $hours += intval($minutes / 60);
            $minutes = $minutes % 60;
        }
    }

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
        $this->form_data["fields"]["image"]["path"] = "../docs/user_{$_SESSION['uid']}/course_";
    }

    public function createFolders($id) {
        $dir = "../docs/user_" . $_SESSION['uid'];

        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        if ($id !== -1) {
            $dir = "../docs/user_" . $_SESSION['uid'] . "/" . "course_" . $id;

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }
        }
    }

    public function performOperation($ids) {
        parent::performOperation($ids);

        if ($_POST['operation'] === "harddelete") {
            foreach ($ids as $id) {
                $dir = "../docs/user_" . $_SESSION['uid'] . "/" . "course_" . $id;
                removeDir($dir);
            }
        }
    }

    function uploadFiles($file_array, $id, $edit = false) {
        $this->createFolders($id["id"]);
        $path = $this->form_data["fields"]["image"]["path"] . $id["id"] . "/";
        $src = "";

//        foreach ($file_array as $field => $file_name) {
//            $tmp_name = $_FILES[$field]['tmp_name'];
////            resiseImage($field);
//            move_uploaded_file($tmp_name, $path . $file_name);
//            return true;
//        }

        foreach ($file_array as $field => $file_name) {
//            $tmp_name = $_FILES[$field]['tmp_name'];
//            resizeImage($field);
//            move_uploaded_file($tmp_name, $path . $file_name);
            $filename = $_FILES[$field]['tmp_name'];
            $img = $_POST['cropped_image'];
            $img = str_replace('data:image/png;base64,', '', $img);
            $img = str_replace(' ', '+', $img);
            $data = base64_decode($img);
            file_put_contents($path . $file_name, $data);
//            resizeImage($path . $file_name);
            return true;
        }
    }

    protected function setExtraInfo($field, $object) {
        $extra = "";
        if ($field === "col1") {
            $extra = [];
            $path = "../docs/user_{$object["c_by_id"]}/course_" . $object["pkey"];
            if ($object["image"] !== "") {
                $extra["image"] = $path . "/" . $object["image"];
            } else {
                $extra["image"] = "";
            }

            if (isset($this->playtimes[$object["pkey"]])) {
                $extra["playtimes"] = $this->playtimes[$object["pkey"]];
            }

            $extra["rating"] = $this->rating[$object["pkey"]];
            $extra["view"] = $this->view[$object["pkey"]];
        }
        return $extra;
    }

    public function rateCourse() {
        $query = "SELECT id FROM review_master WHERE review_by = '{$_SESSION['uid']}' AND course_id = '{$_POST['course_id']}' LIMIT 1";
        $result = $this->find_by_sql($query);

        if (count($result) > 0) {
            $update = "UPDATE review_master "
                    . "SET "
                    . "title = '{$_POST['title']}',"
                    . "message = '{$_POST['message']}',"
                    . "date = '" . date('Y-m-d H:i:s') . "' "
                    . "WHERE id='{$result[0]["id"]}'";
            $result = $this->query($update);
        } else {
            $insert = "INSERT INTO "
                    . "review_master "
                    . "(course_id, rating, review_by, title, message, date)"
                    . "VALUES "
                    . "('{$_POST['course_id']}','{$_POST['rating']}','{$_SESSION['uid']}','{$_POST['title']}','{$_POST['message']}','" . date('Y-m-d H:i:s') . "')";
            $result = $this->query($insert);
        }

        if ($this->affected_rows() > 0) {
            $data = [
                "type" => "success",
                "message" => "Course successfully rated",
                "rating" => $this->getRating($_POST['course_id']),
            ];
            echo json_encode($data);
        } else {
            echo json_encode(setMessage("problem in rating Course", "danger"));
        }
    }

}

$object = new Courses();

include_once '../classes/_common.php';

if (isset($_POST['rate_course'])) {
    $object->rateCourse();
}