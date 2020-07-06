<?php

require_once('../includes/functions.php');
require_once('../classes/_database.php');
require_once('../classes/_gui.php');

class User extends GUI {

    public $form_data_login = array(
        "table" => array("user_master"),
        "title" => "login",
        "color" => "primary",
        "function" => "checkLogin",
        "fields" => array(
            "col1" => array(
                "title" => "email",
                "field" => "email",
                "transform" => "lowercase",
                "type" => "email",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => array("required" => "required")
            ),
            "col2" => array(
                "title" => "password",
                "field" => "password",
                "type" => "password",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => array("required" => "required")
            ),
        )
    );
    public $form_data_register = array(
        "table" => array("user_master"),
        "title" => "signup",
        "color" => "success",
        "function" => "checkRegister",
        "fields" => array(
            "col1" => array(
                "title" => "username",
                "field" => "username",
                "transform" => "lowercase",
                "type" => "text",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => array("required" => "required")
            ),
            "col2" => array(
                "title" => "email",
                "field" => "email",
                "transform" => "lowercase",
                "type" => "email",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => array("required" => "required")
            ),
            "col3" => array(
                "title" => "password",
                "field" => "password",
                "type" => "password",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => array("required" => "required")
            ),
            "col4" => array(
                "title" => "confirm password",
                "type" => "password",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => array("required" => "required")
            ),
        )
    );
    public $form_data_password = ["title" => "change password",
        "color" => "success",
        "id" => "change_password",
        "function" => "changePassword",
        "fields" => ["col1" => ["title" => "new password",
                "field" => "password",
                "type" => "password",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => ["required" => "required", "min" => 8]
            ],
            "col2" => ["title" => "confirm password",
                "field" => "password",
                "type" => "password",
                "label_class" => "col-sm-4",
                "input_class" => "col-sm-8",
                "validation" => ["required" => "required", "min" => 8]
            ],
        ],
        "buttons" => ["buttons" => [["title" => "change",
            "type" => "submit",
            "color" => "success"
                ]
            ]
        ]
    ];
    protected $form_data = [
        "table" => ["user_master", "usertype_master", "user_master", "user_master","module_master"],
        "table_alias" => ["user", "utype", "u1", "u2","module"],
        "join_type" => ["INNER", "LEFT", "LEFT", "LEFT"],
        "join_condition" => [["usertype_id", "id"], ["created_by", "id"], ["updated_by", "id"], ["module_id", "id"]],
        "title" => "user",
        "constraints" => ["unique" => ["col2"]],
        "default_sort" => ["col1"],
        "fields" => ["pkey" => ["field" => "id",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col1" => ["title" => "name",
                "field" => "name",
                "type" => "text",
                "validation" => ["required" => "required"]
            ],
            "col2" => ["title" => "email",
                "field" => "email",
                "type" => "email",
                "transform" => "lowercase",
                "validation" => ["required" => "required"]
            ],
            "email_verified" => [
                "field" => "email_verified",
                "has_default" => "",
                "hide_table" => "",
                "hide_form" => ""
            ],
            "col3" => ["title" => "usertype",
                "title" => "usertype",
                "table" => 1,
                "field" => "usertype_id",
                "foreign_field" => "name",
//                "page_col" => "col1",
//                "page" => "usertype",
                "type" => "select",
                "transform" => "capitalize",
                "multi" => "",
                "validation" => ["required" => "required"]
            ],
            "module" => [
                "title" => "start module",
                "table" => 4,
                //"condition" => " AND dev_only = 0 ",
                "field" => "module_id",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "module",
//                "sub_type" => "typeahead",                
//                "displayKey" => "name",
//                "search_from" => ["name"],
                "type" => "select",
                "validation" => ["required" => "required"],
//                "has_null" => "",
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
                "has_null" => "",
                "hidden" => "",
            ],
            "u_by" => [
                "title" => "updated by",
                "table" => 3,
                "field" => "updated_by",
                "foreign_field" => "name",
                "page_col" => "col1",
                "page" => "user",
                "type" => "select",
                "multi" => "",
                "validation" => ["required" => "required"],
                "has_default" => "",
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
        ]
    ];

    public function __construct() {
        $extra_operation = ["title" => "password",
            "color" => "info",
            "class" => "password_operation multiple",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "key",
            "icon_class" => "hidden-lg",
            "data" => ["title" => "operation", "value" => "password_operation"]
        ];

        $this->operations["password"] = $extra_operation;

        $this->categories["active"]["show"][] = "password";

        parent::__construct();
        if (isset($_SESSION['uid'])) {
            $this->operations["delete"]["condition"] = [
                ["field" => "pkey", "operation" => "!=", "value" => $_SESSION['uid']]
            ];
            $this->operations["deactivate"]["condition"] = [
                ["field" => "pkey", "operation" => "!=", "value" => $_SESSION['uid']]
            ];
        }
    }

    public function authenticate($email, $password) {
        $sql = "SELECT " . $this->getFields() . " FROM " .
                $this->getTables() .
                " WHERE "
                . "user.email='{$email}' AND " .
                " user.password='" . sha1($password) . "' AND " .
                " utype.active = 1 AND user.active = 1 " .
                " LIMIT 1";

        $result_array = $this->find_by_sql($sql);

        if (!empty($result_array)) {
            $user = array_shift($result_array);
            $_SESSION['uid'] = $user["pkey"];
            $_SESSION['uname'] = $user["col1"];
            $_SESSION['utype_name'] = $user["col3"];
            $_SESSION['utype'] = $user["col3_id"];
            $_SESSION['permitted_category'] = $this->getPermittedCategory();
            $_SESSION['permitted_operation'] = $this->getPermittedOperation();
            if ($user['module'] === "") {
                $start_module = "../public/index.php";//$this->getStartModule();
                $user['module'] = "index";
            } else {
                if($user['module'] === NULL || $user['module']===""){
                    $user['module'] = "index";
                }
                
                if (in_array("view", $_SESSION['permitted_operation'][$user['module'] . ".php"])) {
                    $start_module = $user['module'] . ".php";
                } else {
                    $start_module = "../public/index.php";//$this->getStartModule();
                }
            }
            
            $_SESSION["messagebag"][] = setMessage("Hi {$_SESSION['uname']}. Welcome to Progranz");

            $message = ["type" => "success",
                "redirect" => $start_module];

            logAction("login", "login [{$_SESSION['uname']} ({$_SESSION['uid']})] ");
        } else {
            $message = setMessage("Invalid Credentials", "danger");
            logAction("failure", "{$email} | {$password}");
        }
        echo json_encode($message);
    }

    public function changePassword($password, $ids) {
        $rows = [];
        foreach ($ids as $id) {
            $rows[] = "id='{$id}'";
        }

        $query = "UPDATE user_master SET password='" . sha1($password) . "' WHERE " . implode(" OR ", $rows);
        $this->query($query);
        $count_operation = $this->affected_rows();

        if ($count_operation > 0) {
            $message = setMessage("Password successfully changed for {$count_operation} users");
        } else {
            $message = setMessage("No operation performed", "danger");
        }
        echo json_encode($message);
        logAction("activities", ucwords("change password") . " [" . $this->form_data["table"][0] . "][{$_SESSION['uname']} ({$_SESSION['uid']})] ", $query);
    }

    public function signup($name, $email, $password) {
        $query = "SELECT * FROM user_master WHERE email = '{$email}' ";
        $result = $this->find_by_sql($query);

        if (count($result) === 0) {
            $query = "INSERT INTO user_master (name, email, password, usertype_id) "
                    . "values ('{$name}', '{$email}', '" . sha1($password) . "', '61') ";
            $result = $this->query($query);

            if (!$result) {
                $message = setMessage("Error in sign up.", "danger");
//            logAction("login", "login [{$_SESSION['uname']} ({$_SESSION['uid']})] ");
            } else {
                $_POST['mail'] = '';
                $_POST['to'] = $email;
                $_POST['name'] = $name;
                $_POST["subject"] = "activation_key";
                $_POST['activation_key'] = generateRandomString(50);
                $query = "UPDATE user_master set activation_key = '{$_POST['activation_key']}' WHERE email = '{$email}'";
                $result = $this->query($query);
                include_once '../includes/mail.php';

//            $message = setMessage("Successfully sign up. Activation mail sent.");
//            logAction("failure", "{$email} | {$password}");
            }
        } else {
            $message = setMessage("Duplicated Entry", "danger");
        }

        echo json_encode($message);
    }

    protected function setExtraInfo($field, $object) {
        $extra = "";
        if ($field === "col2") {
            $extra = [];
            $extra["email_verified"] = intval($object["email_verified"]) === 1 ? true : false;
        }
        return $extra;
    }

    public function getPermittedCategory() {

        $query = "SELECT id, name FROM module_master WHERE active = 1";
        $modules = $this->find_by_sql($query);
        $permitted_category = [];
        foreach ($modules as $module) {
            $query = "SELECT "
                    . "category_master.name AS category "
                    . "FROM "
                    . "category_permission_master, "
                    . "usertype_master, "
                    . "module_master, "
                    . "category_master "
                    . "WHERE "
                    . "usertype_master.active = 1 AND "
                    . "module_master.active = 1 AND "
                    . "category_master.active = 1 AND "
                    . "category_permission_master.usertype_id = usertype_master.id AND "
                    . "category_permission_master.module_id = module_master.id AND "
                    . "category_permission_master.category_id = category_master.id AND "
                    . "category_permission_master.module_id = {$module['id']} AND "
                    . "category_permission_master.usertype_id = {$_SESSION['utype']}  ORDER BY category_master.sequence";
            $result = $this->find_by_sql($query);
            $categories = [];
            foreach ($result as $res) {
                $categories[] = $res["category"];
            }
            $permitted_category[$module['name'] . ".php"] = $categories;
        }
        return $permitted_category;
    }

    public function getPermittedOperation() {
        $query = "SELECT id, name FROM module_master WHERE active = 1";
        $modules = $this->find_by_sql($query);
        $permitted_operation = [];
        foreach ($modules as $module) {
            $query = "SELECT "
                    . "operation_master.name AS operation "
                    . "FROM "
                    . "operation_permission_master, "
                    . "usertype_master, "
                    . "module_master, "
                    . "operation_master "
                    . "WHERE "
                    . "usertype_master.active = 1 AND "
                    . "module_master.active = 1 AND "
                    . "operation_master.active = 1 AND "
                    . "operation_permission_master.usertype_id = usertype_master.id AND "
                    . "operation_permission_master.module_id = module_master.id AND "
                    . "operation_permission_master.operation_id = operation_master.id AND "
                    . "operation_permission_master.module_id = {$module['id']} AND "
                    . "operation_permission_master.usertype_id = {$_SESSION['utype']} ORDER BY operation_master.sequence";
            $result = $this->find_by_sql($query);
            $operations = [];
            foreach ($result as $res) {
                $operations[] = $res["operation"];
            }
            $permitted_operation[$module['name'] . ".php"] = $operations;
        }
        return $permitted_operation;
    }

    public function getStartModule() {
        include_once '../includes/menu_top_data.php';
        return $this->getFirstAllowedMenu($menu_top_data_left["menu"]);
    }

    public function getFirstAllowedMenu($menu) {
        $allowed_menu = "";
        foreach ($menu as $title => $link) {
            if (!is_array($link["link"])) {
                if (in_array("view", $_SESSION['permitted_operation'][$link["link"]])) {
                    return $link["link"];
                } else {
                    return "";
                }
            } else {
                $allowed_menu = $this->getFirstAllowedMenu($link["link"]);
                if ($allowed_menu !== "") {
                    return $allowed_menu;
                }
            }
        }
        return $allowed_menu;
    }

}

$object = new User();

include_once '../classes/_common.php';

if (isset($_POST['login'])) {
    $uname = trim($_POST['uname']);
    $upass = trim($_POST['upass']);
    $object->authenticate($uname, $upass);
} else if (isset($_POST['signup'])) {
    $uname = trim($_POST['uname']);
    $uemail = trim($_POST['uemail']);
    $upass = trim($_POST['upass']);
    $object->signup($uname, $uemail, $upass);
} else if (isset($_POST['change_password'])) {
    $password = trim($_POST['password']);
    $object->changePassword($password, $_POST['ids']);
} else if (isset($_POST['get_form_login'])) {
    $tab_data = array($object->form_data_login,
        $object->form_data_register
    );
    echo json_encode($tab_data);
} else if (isset($_POST['get_form_password'])) {
    echo json_encode($object->form_data_password);
}