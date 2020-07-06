<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";

class GUI extends Database {

    protected $l_t_w = "col-sm-6";
    protected $r_t_w = "col-sm-6";
    protected $t_w = "col-md-12";
    public $current_page;
    protected $current_class;
    protected $gui_data = [];
    protected $per_page;
    protected $total_pages = 0;
    public $message;
    protected $categories = [
        "total" => ["color" => "info",
            "condition" => [0, 1, -2],
            "show" => ["add"]//, "activate","deactivate", "delete", "restore", "destroy", "harddelete")
        ],
        "active" => ["color" => "success",
            "condition" => 1,
            "show" => ["add", "edit", "delete", "deactivate"]
        ],
        "deactive" => ["color" => "deactivated",
            "condition" => -2,
            "show" => ["add", "delete", "activate"]
        ],
        "deleted" => ["color" => "danger",
            "condition" => 0,
            "show" => ["add", "deactivate", "restore", "destroy"]
        ],
        "destroyed" => ["color" => "destroyed",
            "condition" => -1,
            "show" => ["add", "deactivate", "delete", "restore", "harddelete"]
        ]
    ];
    protected $operations = [
        "add" => ["color" => "primary",
            "category_only" => "",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "plus",
            "icon_class" => "hidden-lg"
        ],
        "edit" => ["color" => "warning",
            "class" => "edit_operation",
            "table_only" => "",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "edit",
            "icon_class" => "hidden-lg",
        ],
        "delete" => ["color" => "danger",
            "class" => "delete_operation multiple",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "times",
            "icon_class" => "hidden-lg",
            "data" => ["title" => "operation", "value" => "delete_operation"]
        ],
        "deactivate" => ["color" => "deactivated",
            "class" => "deactivate_operation multiple",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "ban",
            "icon_class" => "hidden-lg",
            "data" => ["title" => "operation", "value" => "deactivate_operation"]
        ],
        "activate" => ["color" => "success",
            "class" => "activate_operation multiple",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "refresh",
            "icon_class" => "hidden-lg",
            "data" => ["title" => "operation", "value" => "activate_operation"]
        ],
        "restore" => ["color" => "success",
            "class" => "restore_operation multiple",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "refresh",
            "icon_class" => "hidden-lg",
            "data" => ["title" => "operation", "value" => "restore_operation"]
        ],
        "destroy" => ["color" => "destroyed",
            "class" => "destroy_operation multiple",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "trash",
            "icon_class" => "hidden-lg",
            "data" => ["title" => "operation", "value" => "destroy_operation"]
        ],
        "harddelete" => ["color" => "harddelete",
            "class" => "harddelete_operation multiple",
            "visibility" => "hidden-xs hidden-sm hidden-md",
            "icon" => "recycle",
            "icon_class" => "hidden-lg",
            "data" => ["title" => "operation", "value" => "harddelete_operation"]
        ],
    ];

    public function getFileData() {
        $orientation = 'P';
        if (isset($_GET['orientation'])) {
            if ($_GET['orientation'] === 'P' || $_GET['orientation'] === 'L') {
                $orientation = $_GET['orientation'];
            }
        }
        $this->prepareGUI();
        $field_data = $this->form_data["fields"];
        $table_header = [];
        $table_header [] = "#";
        foreach ($this->gui_data["table"]["header"] as $header) {
            $table_header[] = ucwords($header["title"]);
        }

        $table_body = [];
        $table_config = [];
        $count = 1;
        foreach ($this->gui_data["table"]["body"]["row"] as $row_data) {
            $row = [];
            $config = [];
            $config[]["align"] = "C";
            foreach ($row_data["col"] as $col) {
                if (isset($field_data[$col["field"]]["align"])) {
                    switch ($field_data[$col["field"]]["align"]) {
                        case "center":
                            $config[]["align"] = 'C';
                            break;
                        case "left":
                            $config[]["align"] = 'L';
                            break;
                        case "right":
                            $config[]["align"] = 'R';
                            break;
                    }
                } else {
                    $config[]["align"] = "L";
                }

                if (isset($field_data[$col["field"]]["transform"])) {
                    switch ($field_data[$col["field"]]["transform"]) {
                        case "uppercase":
                            $row[] = strtoupper($col["value"]);
                            break;
                        case "lowercase":
                            $row[] = strtolower($col["value"]);
                            break;
                        case "capitalize":
                        default :
                            $row[] = ucwords($col["value"]);
                            break;
                    }
                } else {
                    $row[] = ucwords($col["value"]);
                }
            }
            array_unshift($row, $count++);
            $table_body[] = $row;
            $table_config = $config;
        }
        $title = $_SESSION['active_menu'];
        $settings = [
            "filename" => str_replace(" ", "_", $this->form_data["title"]) . "_" . date("d_m_Y_H_i_s"),
            "orientation" => $orientation
        ];
        return ["header" => $table_header, "body" => $table_body, "title" => $title, "settings" => $settings, "config" => $table_config];
    }

    public function __construct() {
        parent::__construct();
        global $current_page, $current_class;
        $this->current_page = $current_page;
        $this->current_class = $current_class;
        $this->message = [];

        $not_check = ["index.php"];
        if (!isset($_SESSION["permitted_operation"])) {
            $not_check[] = "user.php";
        }
        if (!in_array($current_page, $not_check) && isset($_SESSION['uid'])) {
            if (isset($this->form_data)) {
                foreach ($this->form_data["fields"] as $field => $field_array) {
                    if (isset($field_array["type"])) {
                        if ($field_array["type"] === "select") {
                            if (isset($field_array["page"])) {
                                $page = $field_array["page"] . ".php";
                                if (!in_array("add", $_SESSION["permitted_operation"][$page])) {
                                    unset($this->form_data["fields"][$field]["page"]);
                                    unset($this->form_data["fields"][$field]["page_col"]);
                                }
                            }
                        }
                    }
                }
            }
            $this->setPermissions();
        }
    }

    public function setPermissions() {
        foreach ($this->categories as $title => $category) {
            if (isset($_SESSION["permitted_category"][$this->current_page])) {
                if (in_array($title, $_SESSION["permitted_category"][$this->current_page]) !== false) {
                    $this->categories[$title]["allowed"] = true;
                } else {
                    $this->categories[$title]["allowed"] = false;
                }
            } else {
                $this->operations[$title]["allowed"] = false;
            }
        }

        foreach ($this->operations as $title => $operation) {
            if (isset($_SESSION["permitted_operation"][$this->current_page])) {
                if (in_array($title, $_SESSION["permitted_operation"][$this->current_page]) !== false) {
                    $this->operations[$title]["allowed"] = true;
                } else {
                    $this->operations[$title]["allowed"] = false;
                }
            } else {
                $this->operations[$title]["allowed"] = false;
            }
        }
    }

    public function getSearchBox() {
        $this->gui_data["taskbars"]["right_taskbar"]["searchbox"]["search"] = $_SESSION["sessions"][$this->current_page]['search'];

        $date_fields = [];
        foreach ($this->form_data["fields"] as $field => $field_array) {
            if (!isset($field_array['hide_table'])) {
                if (isset($field_array['type'])) {
                    if ($field_array['type'] === "date" || $field_array['type'] === "datetime") {
                        $date_fields[] = $field;
                    }
                }
            }
        }

        $this->gui_data["taskbars"]["right_taskbar"]["searchbox"]["date_fields"] = $date_fields;
    }

    public function getButtons($buttons, $check = false, $object = false) {
        $ret_buttons = [];
        foreach ($buttons as $button) {
            if ($check !== false) {
                $passed = true;
                if (isset($button["condition"]) && $object !== false) {
                    $passed = $this->checkCondition($button["condition"], $object);
                }

                if (in_array($button['title'], $this->categories[$check]['show']) !== false && $button["allowed"] && $passed) {
                    $ret_buttons[] = $button;
                }
            } else {
                if ($button["allowed"]) {
                    $ret_buttons[] = $button;
                }
            }
        }
        return $ret_buttons;
    }

    public function getTable($table_class = "col-md-12") {

        $objects = $this->categoryCount($this->categories[$_SESSION["sessions"][$this->current_page]['category']], true);
        $this->gui_data["table"]["operations"] = $_SESSION["sessions"][$this->current_page]["operations"];
        $this->gui_data["table"]["col_width"] = $table_class;
        if (isset($_SESSION["sessions"][$this->current_page]["sort"])) {
            $this->gui_data["table"]["sort"] = $_SESSION["sessions"][$this->current_page]["sort"];
            $this->gui_data["table"]["order"] = $_SESSION["sessions"][$this->current_page]["order"];
        }

        if (count($objects) > 0) {

            $operations = [];
            foreach ($this->operations as $title => $operation) {
                if (!isset($operation["allowed"])) {
                    $operation["allowed"] = false;
                }
                if (!isset($operation["category_only"]) && $operation["allowed"]) {
                    if ($title === "edit") {
                        $operation['data'] = ["title" => "modal",
                            "value" => "edit" . $this->form_data["title"]];
                    }
                    $operation['size'] = 'btn-xs';
                    $operation["class"] = isset($operation["class"]) ? $operation["class"] : "";
                    unset($operation["visibility"]);
                    unset($operation["icon"]);
                    unset($operation["icon_class"]);
                    $operation["title"] = $title;
                    $operations[] = $operation;
                }
            }


            $this->getTableHeader();
            $this->getTableBody($objects, $operations);
        }
    }

    public function getTableHeader() {
        $i = 0;
        foreach ($this->form_data["fields"] as $field => $field_array) {
            if (!isset($field_array['hide_table']) && !$this->isFiltered($field)) {
                if (isset($field_array['not_sortable'])) {
                    $this->gui_data["table"]["header"][] = ["title" => $field_array['title']
                    ];
                    $i++;
                } else {
                    $icon = $this->getSortIcon($field);
                    $sort = $this->getSortData($field);

//$default_only = count(array_diff($_SESSION["sessions"][$this->current_page]['sort'], $this->form_data["default_sort"])) ? false : true;
                    $default_only = count($_SESSION["sessions"][$this->current_page]['sort']) === 1 ? true : false;
                    $this->gui_data["table"]["header"][] = [
                        "title" => $field_array['title'],
                        "icon" => $icon,
                        "sort" => ["sort" => $sort["sort"],
                            "order" => $sort["order"]
                        ]
                    ];

                    if (array_search($field, $_SESSION["sessions"][$this->current_page]['sort']) !== false && !$default_only) {
                        $this->gui_data["table"]["header"][$i]["remove"] = "";
                    }

                    if (isset($field_array["multi"])) {
                        $table_field = $this->form_data["table_alias"][0] . "." . $this->form_data["fields"][$field]["field"];
                        $this->gui_data["table"]["header"][$i]["filter"] = $_SESSION["sessions"][$this->current_page]["multi"][$table_field];
                        $this->gui_data["table"]["header"][$i]["field"] = $field;
                    }

                    $i++;
                }
            }
        }
    }

    public function getTableBody($objects, $operations) {
        $row_count = intval($_SESSION["sessions"][$this->current_page]['current_page']) * intval($_SESSION["sessions"][$this->current_page]['per_page']) + 1;
        $this->gui_data["table"]["body"]["start_sr_no"] = $row_count;
        $this->gui_data["table"]["body"]["operations"] = 0;
        $i = 0;
        foreach ($objects as $object) {
            $tr_class = "";
            switch ($object["act"]) {
                case 0:
                    $tr_class = "bg-danger";
                    break;
                case -2:
                    $tr_class = "bg-deactivated'";
                    break;
                case -1:
                    $tr_class = "bg-destroyed'";
                    break;
            }

            $this->gui_data["table"]["body"]["row"][$i]["id"] = $object["pkey"];
            $allowed_operations = $this->getButtons($operations, $this->getCategory($object["act"]), $object);
            $this->gui_data["table"]["body"]["operations"] += count($allowed_operations);
            $this->gui_data["table"]["body"]["row"][$i]["operations"] = $allowed_operations;
            $this->gui_data["table"]["body"]["row"][$i]["tr_class"] = $tr_class;

            foreach ($this->form_data["fields"] as $field => $field_array) {
                if (!isset($field_array['hide_table']) && !$this->isFiltered($field)) {
                    $align = isset($field_array['align']) ? "text-" . $field_array['align'] : "";
                    $transform = isset($field_array['transform']) ? "text-" . $field_array['transform'] : "text-capitalize";

                    if ($object[$field] !== '' && $object[$field] !== NULL) {
                        if ($field_array["type"] === "date") {
                            $object[$field] = date('d-m-Y', strtotime($object[$field]));
                        } else if ($field_array["type"] === "datetime") {
                            $object[$field] = date('d-m-Y h:i:s A', strtotime($object[$field]));
                        } else if ($field_array["type"] === "textarea") {
                            $object[$field] = br2nl(nl2br($object[$field]));
                        }
                    }


                    $extra = $this->setExtraInfo($field, $object);

                    $this->gui_data["table"]["body"]["row"][$i]["col"][] = [
                        "field" => $field,
                        "align" => $align,
                        "transform" => $transform,
                        "value" => strtolower($object[$field]),
                        "extra" => $extra
                    ];
                }
            }
            $i++;
        }
    }

    protected function setExtraInfo($field, $object) {
        return "";
    }

    public function getTaskbars($col_left_width = "col-sm-6", $col_right_width = "col-sm-6") {
        $this->getLeftTaskbar($col_left_width);
        $this->getRightTaskbar($col_right_width);
    }

    public function getLeftTaskbar($col_width = "col-md-6") {
        $operations = [];
        foreach ($this->operations as $title => $operation) {
            if (!isset($operation["table_only"])) {
                if ($title === "add") {
                    $operation['data'] = ["title" => "modal",
                        "value" => "insert" . $this->form_data["title"]];
                } else {
                    if (!isset($operation["always_visible"])) {
                        $operation["class"] = isset($operation["class"]) ? $operation["class"] . " hidden" : "hidden";
                    }
                }
                $operation["title"] = $title;
                $operations[] = $operation;
            }
        }

        $this->gui_data["taskbars"]["left_taskbar"]["col_width"] = $col_width;
        $this->getCategories();
        $this->getPerPage();
        $this->gui_data["taskbars"]["left_taskbar"]["operations"] = $this->getButtons($operations, $_SESSION["sessions"][$this->current_page]['category']); //second parameter for opeartions flag
    }

    public function getRightTaskbar($col_width = "col-md-6") {
        $this->gui_data["taskbars"]["right_taskbar"]["col_width"] = $col_width;
        $this->getSearchBox();
    }

    public function getList($list_data) {
        $i = 0;
        foreach ($list_data as $index => $list_item) {
            $print_list = true;
            $count = "";
            if (isset($list_item["count"])) {
                $count = $list_item["count"];
                if (intval($list_item["count"]) === 0 && ($index !== $_SESSION["sessions"][$this->current_page]['category'])) {
                    $print_list = false;
                }
            }

            if (!isset($list_item["allowed"])) {
                $list_item["allowed"] = false;
            }

            if ($print_list && $list_item["allowed"]) {
                $this->gui_data["taskbars"]["left_taskbar"]["categories"][] = ["data" => [["title" => "category", "value" => $index]],
                    "title" => $index,
                    "count" => $count
                ];

                if ($index === $_SESSION["sessions"][$this->current_page]['category']) {
                    $this->gui_data["taskbars"]["left_taskbar"]["categories"][$i]["color"] = $this->categories[$_SESSION["sessions"][$this->current_page]['category']]["color"];
                    $this->gui_data["taskbars"]["left_taskbar"]["categories"][$i]["selected"] = "";
                }

                $i++;
            }
        }
    }

    public function getCategories() {
        $this->getList($this->categories);
    }

    public function getPerPage() {
        $total_count = intval($this->categories[$_SESSION["sessions"][$this->current_page]['category']]['count']);
        $display_per_page = true;
        if (count($this->per_page) === 1 &&
                ($_SESSION["sessions"][$this->current_page]['per_page'] === 'all' || (intval($_SESSION["sessions"][$this->current_page]['per_page']) > $total_count))) {
            $display_per_page = false;
        }

        $list_count = 0;
        $per_page_text = "";

        if ($display_per_page) {
            $i = 0;
            foreach ($this->per_page as $index => $list_item) {
                if ($total_count >= intval($list_item)) {
                    $list_count++;
                    $this->gui_data["taskbars"]["left_taskbar"]["per_page"][] = ["data" => [["title" => "per_page", "value" => $list_item]],
                        "title" => $list_item
                    ];

                    if (intval($list_item) === intval($_SESSION["sessions"][$this->current_page]['per_page'])) {
                        $this->gui_data["taskbars"]["left_taskbar"]["per_page"][$i]["selected"] = "";
                    }
                    $i++;
                }
            }
        }
    }

    public function setSessions() {
        if (isset($_SESSION["sessions"]) && !isset($_POST['preserve'])) {
            foreach ($_SESSION["sessions"] as $page => $session) {
                if ($page !== $this->current_page) {
                    unset($_SESSION["sessions"][$page]);
                }
            }
        }

//session for displaying operations
        if (!isset($_SESSION["sessions"][$this->current_page]['operations'])) {
            $_SESSION["sessions"][$this->current_page]['operations'] = "table-cell";
        }

//session for displaying category row
        if (!isset($_SESSION["sessions"][$this->current_page]['hide'])) {
            $_SESSION["sessions"][$this->current_page]['hide'] = "block";
        }
        $this->gui_data["hide"] = $_SESSION["sessions"][$this->current_page]["hide"];

//remove sort
        if (isset($_GET['remove_sort'])) {
            $key = array_search($_GET['remove_sort'], $_SESSION["sessions"][$this->current_page]['sort']);
            unset($_SESSION["sessions"][$this->current_page]['sort'][$key]);
            unset($_SESSION["sessions"][$this->current_page]['order'][$_GET['remove_sort']]);
            sort($_SESSION["sessions"][$this->current_page]['sort']);
            sort($_SESSION["sessions"][$this->current_page]['order']);
        }
        if (isset($_GET['remove_search'])) {
            $_SESSION["sessions"][$this->current_page]['search'] = '';
        }

        if (isset($_GET['remove_asearch'])) {
            unset($_SESSION["sessions"][$this->current_page]['asearch']);
        }

//set active catagory
        if (isset($_GET['category'])) {
            if (isset($_SESSION["sessions"][$this->current_page]['category'])) {
                if ($_SESSION["sessions"][$this->current_page]['category'] !== $_GET['category']) {
                    unset($_SESSION["sessions"][$this->current_page]['current_page']);
                }
            }
            $_SESSION["sessions"][$this->current_page]['category'] = $_GET['category'];
            unset($_SESSION["sessions"][$this->current_page]["multi"]);
        } else if (!isset($_SESSION["sessions"][$this->current_page]['category'])) {
            $_SESSION["sessions"][$this->current_page]['category'] = $_SESSION['permitted_category'][$this->current_page][0];
        }

        $this->prepareMultiFilter();
        $this->prepareHeaderFilter();
        $this->prepareSearchFilter();

//set sort fields (Array)
        $sort_not_set = !isset($_SESSION["sessions"][$this->current_page]['sort']);
        $sort_empty = empty($_SESSION["sessions"][$this->current_page]['sort']);
        if (isset($_GET['sort'])) {
            if (!isset($_SESSION["sessions"][$this->current_page]["sort"])) {
                $_SESSION["sessions"][$this->current_page]["sort"] = [];
            }
            if (!in_array($_GET['sort'], $_SESSION["sessions"][$this->current_page]["sort"])) {
                $_SESSION["sessions"][$this->current_page]['sort'][] = $_GET['sort'];
            }
        } else if ($sort_not_set) {
            $_SESSION["sessions"][$this->current_page]['sort'] = $this->form_data["default_sort"];
        } else if ($sort_empty) {
            $_SESSION["sessions"][$this->current_page]['sort'][] = $this->getFirstNonFiltered();
        }

//set sort fields order (Array)
        $order_not_set = !isset($_SESSION["sessions"][$this->current_page]['order']);
        $order_empty = empty($_SESSION["sessions"][$this->current_page]['order']);
        if (isset($_GET['order'])) {
            if (!isset($_SESSION["sessions"][$this->current_page]["order"])) {
                $_SESSION["sessions"][$this->current_page]["order"] = [];
            }
            $_SESSION["sessions"][$this->current_page]['order'][$_GET['sort']] = $_GET['order'];
        } else if ($order_not_set) {
            if (isset($this->form_data["default_order"])) {
                $_SESSION["sessions"][$this->current_page]['order'] = $this->form_data["default_order"];
            } else {
                $_SESSION["sessions"][$this->current_page]['order'][$this->getFirstNonFiltered()] = "asc";
            }
        } else if ($order_empty) {
            $_SESSION["sessions"][$this->current_page]['order'][$this->getFirstNonFiltered()] = "asc";
        }

//set search
        if (isset($_GET['search'])) {
            if (isset($_SESSION["sessions"][$this->current_page]['search'])) {
                if ($_SESSION["sessions"][$this->current_page]['search'] !== $_GET['search']) {
                    unset($_SESSION["sessions"][$this->current_page]['search']);
                }
            }
            $_SESSION["sessions"][$this->current_page]['search'] = $_GET['search'];
        } else if (!isset($_SESSION["sessions"][$this->current_page]['search'])) {
            $_SESSION["sessions"][$this->current_page]['search'] = '';
        }

//set current page
        if (isset($_GET['page'])) {
            $_SESSION["sessions"][$this->current_page]['current_page'] = $_GET['page'];
        } else if (!isset($_SESSION["sessions"][$this->current_page]['current_page'])) {
            $_SESSION["sessions"][$this->current_page]['current_page'] = 0;
        }

//set per page
        $this->categoriesCount();

        $this->per_page = [];
        $per_page = $this->find_by_sql("SELECT page AS col1 FROM per_page_master WHERE active=1 ORDER BY col1 ASC");

        if ($this->current_page === "courses.php") {
            if (!isset($_GET["admin"])) {
                array_unshift($per_page, ["col1" => 6]);
            }
        }

//        print_r($per_page);

        if (empty($per_page)) {
            $temp_pages = [25, 50, 100, 200];
            foreach ($temp_pages as $page) {
                if (intval($this->categories[$_SESSION["sessions"][$this->current_page]['category']]['count']) > $page) {
                    $this->per_page[] = $page;
                    break;
                }
            }
        } else {
            foreach ($per_page as $page) {
                if (intval($this->categories[$_SESSION["sessions"][$this->current_page]['category']]['count']) > intval($page["col1"])) {
                    $this->per_page[] = intval($page["col1"]);
                } else {
                    break;
                }
            }
        }

        if (isset($_GET['per_page'])) {
            if (isset($_SESSION["sessions"][$this->current_page]['per_page'])) {
                if ($_SESSION["sessions"][$this->current_page]['per_page'] !== $_GET['per_page']) {
                    $_SESSION["sessions"][$this->current_page]['current_page'] = 0;
                }
            }
            $_SESSION["sessions"][$this->current_page]['per_page'] = $_GET['per_page'];
        } else if (!isset($_SESSION["sessions"][$this->current_page]['per_page'])) {
            if (!empty($this->per_page)) {
                $_SESSION["sessions"][$this->current_page]['per_page'] = $this->per_page[0];
            } else {
                $_SESSION["sessions"][$this->current_page]['per_page'] = 'all';
            }
        }

        if (!empty($this->per_page)) {
            if (intval($this->categories[$_SESSION["sessions"][$this->current_page]['category']]['count']) > intval($this->per_page[count($this->per_page) - 1])) {
                $this->per_page[] = 'all';
            }
        }

        if ($_SESSION["sessions"][$this->current_page]['per_page'] !== 'all') {
            $this->total_pages = intval(ceil($this->categories[$_SESSION["sessions"][$this->current_page]['category']]["count"] / intval($_SESSION["sessions"][$this->current_page]['per_page'])));
        } else {
            $this->total_pages = 1;
        }

        $this->gui_data["search_filter"] = $_SESSION["sessions"][$this->current_page]["search_filter"];
        $this->gui_data["header_filter"] = $_SESSION["sessions"][$this->current_page]["header"];
        $this->gui_data["form_data"] = $this->form_data;
        if (isset($_SESSION["sessions"][$this->current_page]['datebox'])) {
            $this->gui_data["datebox"] = $_SESSION["sessions"][$this->current_page]['datebox'];
        }

        if (isset($_SESSION["sessions"][$this->current_page]['asearch'])) {
            $this->gui_data["asearch"] = $_SESSION["sessions"][$this->current_page]['asearch'];
        }
    }

    public function categoryCount(&$category, $pagination = false) {
//create active condition query
        $multi = "";
        if (isset($_SESSION["sessions"][$this->current_page]['multi'])) {
            foreach ($_SESSION["sessions"][$this->current_page]['multi'] as $field => $value) {
                $multi_value = [];
                foreach ($value as $v) {
                    if (isset($v["selected"])) {
                        if ($v["id"] === "null") {
                            $multi_value[] = $field . " IS NULL ";
                        } else {
                            $multi_value[] = $field . "='" . $v["id"] . "'";
                        }
                    }
                }
                if (count($multi_value) > 0) {
                    $multi .= " AND (" . implode(" OR ", $multi_value) . " ) ";
                }
                //echo $field.">>"." AND (" . implode(" OR ", $multi_value) . " ) "."<<\n\n";
            }
        }

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

            for ($i = 1; $i < count($this->form_data["table"]); $i++) {
                if ($this->form_data["join_type"][$i - 1] === "INNER") {
                    $query_condition .= " AND " . $this->form_data["table_alias"][$i] . ".active = 1 ";
                }
            }

            $query_condition = "WHERE {$query_condition}";
        }

//create sort query
        if (count($_SESSION["sessions"][$this->current_page]['sort'])) {
            $sort_order = [];
            foreach ($_SESSION["sessions"][$this->current_page]["sort"] as $sort_field) {
                if (!isset($_SESSION["sessions"][$this->current_page]['order'][$sort_field])) {
                    $_SESSION["sessions"][$this->current_page]['order'][$sort_field] = "asc";
                }
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

        $date_search_query = [];
        if (isset($_SESSION["sessions"][$this->current_page]['datebox'])) {
            foreach ($_SESSION["sessions"][$this->current_page]['datebox'] as $field => $field_array) {
                $default_table = $this->form_data["table_alias"][0];
                $table_name = isset($this->form_data["fields"][$field]["table"]) ? $this->form_data["table_alias"][$field_array["table"]] : $default_table;

                switch ($field_array['date_filter']) {
                    case "custom_date":
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " like '" . $_SESSION["sessions"][$this->current_page]['datebox'][$field]["start_date"] . "%'";
                        break;
                    case "custom_range":
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " >= '" . $_SESSION["sessions"][$this->current_page]['datebox'][$field]["start_date"] . "%'";
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " <= '" . $_SESSION["sessions"][$this->current_page]['datebox'][$field]["end_date"] . "%'";
                        break;
                    case "today":
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " like '" . date("Y-m-d") . "%'";
                        break;
                    case "yesterday":
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " like '" . date('Y-m-d', strtotime("yesterday")) . "%'";
                        break;
                    case "this_week":
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " >= '" . rangeWeek(date('y-m-d'))['start'] . " 00:00:00'";
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " <= '" . rangeWeek(date('y-m-d'))['end'] . " 23:59:59'";
                        break;
                    case "last_week":
                        $last_week = date('Y-m-d', strtotime('last week monday'));
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " >= '" . rangeWeek($last_week)['start'] . " 00:00:00'";
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " <= '" . rangeWeek($last_week)['end'] . " 23:59:59'";
                        break;
                    case "this_month":
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " >= '" . rangeMonth(date('y-m-d'))['start'] . " 00:00:00'";
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " <= '" . rangeMonth(date('y-m-d'))['end'] . " 23:59:59'";
                        break;
                    case "last_month":
                        $last_month = date('Y-m-d', strtotime('last month first day'));
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " >= '" . rangeMonth($last_month)['start'] . " 00:00:00'";
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " <= '" . rangeMonth($last_month)['end'] . " 23:59:59'";
                        break;
                    case "this_year":
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " >= '" . rangeYear()['start'] . " 00:00:00'";
                        $date_search_query[] = $table_name . "." . $this->form_data["fields"][$field]["field"] . " <= '" . rangeYear()['end'] . " 23:59:59'";
                        break;
                }
            }
            if (!empty($date_search_query)) {
                $date_search_query = " AND " . implode(" AND ", $date_search_query);
            } else {
                $date_search_query = "";
            }
        } else {
            $date_search_query = "";
        }
        $asearch = "";
        if (isset($_SESSION["sessions"][$this->current_page]['asearch'])) {
            $default_table = $this->form_data["table_alias"][0];
            foreach ($_SESSION["sessions"][$this->current_page]['asearch'] as $group => $group_condition) {
                $condition_join = $group_condition["join"];
                $asearch .= "(";
                foreach ($group_condition["condition"] as $key => $asearch_condition) {
                    $field = $asearch_condition["field"];
                    $table_name = isset($this->form_data["fields"][$field]["table"]) ? $this->form_data["table"][$this->form_data["fields"][$field]["table"]] : $default_table;
                    $condition = strtolower($asearch_condition["condition"]);
                    $value = $asearch_condition["value"];
                    $join = isset($asearch_condition["join"]) ? strtoupper($asearch_condition["join"]) . " " : "";
                    $field = isset($this->form_data["fields"][$field]["foreign_field"]) ? $this->form_data["fields"][$field]["foreign_field"] : $this->form_data["fields"][$field]["field"];

                    switch ($condition) {
                        case "starts with":
                            $asearch .= $table_name . "." . $field . " LIKE '" . $value . "%' " . $join;
                            break;
                        case "ends with":
                            $asearch .= $table_name . "." . $field . " LIKE '%" . $value . "' " . $join;
                            break;
                        case "equals":
                            $asearch .= $table_name . "." . $field . " = '" . $value . "' " . $join;
                            break;
                        case "contains":
                            $asearch .= $table_name . "." . $field . " LIKE '%" . $value . "%' " . $join;
                            break;
                        case "does not start with":
                            $asearch .= $table_name . "." . $field . " NOT LIKE '" . $value . "%' " . $join;
                            break;
                        case "does not end with":
                            $asearch .= $table_name . "." . $field . " NOT LIKE '%" . $value . "' " . $join;
                            break;
                        case "does not equal to":
                            $asearch .= $table_name . "." . $field . " != '" . $value . "' " . $join;
                            break;
                        case "does not contain":
                            $asearch .= $table_name . "." . $field . " NOT LIKE '%" . $value . "%' " . $join;
                            break;
                        case ">":
                            $asearch .= $table_name . "." . $field . " > '" . $value . "' " . $join;
                            break;
                        case ">=":
                            $asearch .= $table_name . "." . $field . " >= '" . $value . "' " . $join;
                            break;
                        case "<":
                            $asearch .= $table_name . "." . $field . " < '" . $value . "' " . $join;
                            break;
                        case "<=":
                            $asearch .= $table_name . "." . $field . " <= '" . $value . "' " . $join;
                            break;
                        case "not =":
                            $asearch .= $table_name . "." . $field . " != '" . $value . "' " . $join;
                            break;
                        case "=":
                            $asearch .= $table_name . "." . $field . " = '" . $value . "' " . $join;
                            break;
                    }
                }

                $asearch .= ")";
                if ($condition_join !== "") {
                    $asearch .= " " . $condition_join;
                }
            }
        }

        $asearch = $asearch !== "" ? " AND ( {$asearch} ) " : "";

//join condition
        $join = "";
        if (isset($this->form_data['join'])) {
            $join = " AND " . $this->form_data['join'];
        }

//create full query
        if ($category["condition"] !== $this->categories[$_SESSION["sessions"][$this->current_page]['category']]["condition"]) {
            $multi = "";
        }

        $table_condition = "";

        if (isset($this->form_data['table_condition'])) {
            $table_condition = " AND " . $this->form_data['table_condition'];
        }

        $query = "SELECT " . $this->getFields() . " FROM " . $this->getTables() . " " .
                " {$query_condition} {$search_query} {$multi} {$date_search_query} {$asearch} {$table_condition} " . //{$join} " .
                " {$sort_query} {$pagination}";

        $objects = $this->find_by_sql($query);
        $category["count"] = count($objects);
//        echo "\n\n".$query."\n\n";
        logAction("activities", "query", $query);
        return $objects;
    }

    public function categoriesCount() {
        foreach ($this->categories as $key => $category) {
            if (in_array($key, $_SESSION['permitted_category'][$this->current_page])) {
                $this->categoryCount($this->categories[$key]);
            }
        }
    }

    public function getSortIcon($field) {
        if (in_array($field, $_SESSION["sessions"][$this->current_page]['sort'])) {
            if ($_SESSION["sessions"][$this->current_page]['order'][$field] === "asc") {
                return "fa fa-caret-up";
            } else {
                return "fa fa-caret-down";
            }
        } else {
            return "";
        }
    }

    public function getSortData($field) {
        $sort_array = [];
        if (in_array($field, $_SESSION["sessions"][$this->current_page]['sort'])) {
            if ($_SESSION["sessions"][$this->current_page]['order'][$field] === "asc") {
                $sort_array["sort"] = $field;
                $sort_array["order"] = "desc";
            } else {
                $sort_array["sort"] = $field;
                $sort_array["order"] = "asc";
            }
        } else {
            $sort_array["sort"] = $field;
            $sort_array["order"] = "asc";
        }
        return $sort_array;
    }

    public function getCategory($active) {
        $row_category = false;
        foreach ($this->categories as $key => $category) {
            if (isset($category["condition"])) {
                if ($category["condition"] === intval($active)) {
                    $row_category = $key;
                    break;
                }
            }
        }
        return $row_category;
    }

    protected function getSelect() {
        foreach ($this->form_data["fields"] as $key => $field) {
            if (isset($field["type"])) {
                if ($field["type"] === "select") {
//SELECT id, name FROM usertype_master WHERE 
                    $condition = isset($field["condition"]) ? $field["condition"] : "";
                    $query = "SELECT id, {$field["foreign_field"]} FROM {$this->form_data["table"][$field["table"]]} WHERE active=1 {$condition} ORDER BY {$field["foreign_field"]} ASC";
                    $select_rows = $this->find_by_sql($query);
                    foreach ($select_rows as $row) {
                        $this->form_data["fields"][$key]["select_data"][] = ["id" => $row["id"], "name" => $row[$field["foreign_field"]]];
                    }
                }
            }
        }
    }

    public function getForm() {
        $this->getSelect();
        if ($_POST["add_edit"] === "edit") {
            $id = $_POST['id'];
            $join = isset($this->form_data["join"]) ? " AND " . $this->form_data["join"] : "";

            $query = "SELECT " . $this->getFields(true) . " FROM " . $this->getTables() . " " .
                    "WHERE " . $this->form_data["table_alias"][0] . ".id='{$id}' "; //{$join}
            $object = $this->find_by_sql($query);
            foreach ($this->form_data["fields"] as $key => $field) {
                if ($field["field"] !== "NA") {
                    $this->form_data["fields"][$key]["value"] = $object[0][$key];
                    if (isset($field["foreign_field"]) && !isset($field["hide_form"])) {
                        $this->form_data["fields"][$key]["value_name"] = $object[0][$key . "_name"];
                    }
                } else {
                    $this->form_data["fields"][$key]["value"] = "";
                }
            }
        }
        echo json_encode($this->form_data);
    }

    public function getPagination() {
        $total_pages = $this->total_pages;
        if ($total_pages > 1) {

            $start = intval(floor($_SESSION["sessions"][$this->current_page]['current_page'] / PAGINATION_LIMIT) * PAGINATION_LIMIT);
            $end = intval($start + intval(PAGINATION_LIMIT));

            if ($end > $total_pages) {
                $end = $total_pages;
            }

            $this->gui_data["pagination"]["total_pages"] = $total_pages;
            $this->gui_data["pagination"]["start"] = $start;
            $this->gui_data["pagination"]["end"] = $end;
            $this->gui_data["pagination"]["current_page"] = $_SESSION["sessions"][$this->current_page]['current_page'];
        }
    }

    public function prepareGUI() {
        $this->setSessions();
        $this->getTaskbars($this->l_t_w, $this->r_t_w);
        $this->getTable($this->t_w);
        $this->getPagination();
        return $this->gui_data;
    }

    public function prepareMultiFilter() {
        $category = $this->categories[$_SESSION["sessions"][$this->current_page]['category']];
        if (is_array($category['condition'])) {
            foreach ($category['condition'] as $condition) {
                $query_condition[] = $this->form_data["table_alias"][0] . ".active='{$condition}'";
            }
            $query_condition = "(" . implode(" OR ", $query_condition) . ")";
        } else {
            $query_condition = $this->form_data["table_alias"][0] . ".active='" . $category['condition'] . "'";
        }

        $query_condition = "WHERE {$query_condition} ";

        foreach ($this->form_data["fields"] as $field => $field_array) {
            if (isset($field_array["multi"])) {
                $field_name = $this->form_data["fields"][$field];
                $table_field = $this->form_data["table_alias"][0] . "." . $field_name["field"];
                $foreign_field = $field_name["foreign_field"];
                $query = "SELECT DISTINCT "
                        . "{$this->form_data["table_alias"][$field_name["table"]]}.id as id, "
                        . "{$this->form_data["table_alias"][$field_name["table"]]}.{$foreign_field} as {$foreign_field} "
                        . "FROM "
                        . "{$this->form_data["table"][$field_name["table"]]} {$this->form_data["table_alias"][$field_name["table"]]} "
                        . "RIGHT JOIN  "
                        . "" . $this->form_data["table"][0] . " {$this->form_data["table_alias"][0]} "
                        . "ON {$this->form_data["table_alias"][$field_name["table"]]}.active = 1 AND "
                        . $this->form_data["table_alias"][$field_name["table"]] . ".id = " . $this->form_data["table_alias"][0] . " . {$field_array["field"]} "
                        . $query_condition
                        . "ORDER BY {$this->form_data["table_alias"][$field_name["table"]]}.{$foreign_field} ASC";
                $multi = $this->find_by_sql($query);
                //echo $query."\n\n";
                //is session not set
                if (!isset($_SESSION["sessions"][$this->current_page]["multi"][$table_field])) {
                    for ($i = 0; $i < count($multi); $i++) {
                        if ($multi[$i]["name"] === null) {
                            $multi[$i]["id"] = "null";
                            $multi[$i]["name"] = "null";
                        }
                        $multi[$i]["selected"] = "";
                    }
                    if (!empty($multi)) {
                        $_SESSION["sessions"][$this->current_page]["multi"][$table_field] = $multi;
                    }
                } else {
                    //if session set add or remove 
                    if (!empty($multi)) {
                        $selected = 0;
                        $total = count($_SESSION["sessions"][$this->current_page]["multi"][$table_field]);
                        foreach ($_SESSION["sessions"][$this->current_page]["multi"][$table_field] as $key => $value) {
                            if (isset($value["selected"])) {
                                $selected++;
                            }
                        }
                        $add = $selected === $total ? true : false;
                        $new_array = [];
                        /* add new array */
                        foreach ($multi as $multi_array) {
                            $found = false;
                            foreach ($_SESSION["sessions"][$this->current_page]["multi"][$table_field] as $key => $value) {
                                if ($multi_array["name"] === null) {
                                    $multi_array["id"] = "null";
                                    $multi_array["name"] = "null";
                                }
                                if ($multi_array["name"] === $value["name"]) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                if ($add) {
                                    $multi_array["selected"] = "";
                                }
                                $new_array[] = $multi_array;
                            }
                        }
                        if (!empty($new_array)) {
                            $_SESSION["sessions"][$this->current_page]["multi"][$table_field] = array_merge($_SESSION["sessions"][$this->current_page]["multi"][$table_field], $new_array);
                            sort($_SESSION["sessions"][$this->current_page]["multi"][$table_field]);
                        }
                        /* delete array */
                        foreach ($_SESSION["sessions"][$this->current_page]["multi"][$table_field] as $key => $value) {
                            $found = false;
                            foreach ($multi as $multi_array) {
                                if ($multi_array["name"] === null) {
                                    $multi_array["id"] = "null";
                                    $multi_array["name"] = "null";
                                }
                                if ($multi_array["name"] === $value["name"]) {
                                    $found = true;
                                    break;
                                }
                            }
                            if (!$found) {
                                unset($_SESSION["sessions"][$this->current_page]["multi"][$table_field][$key]);
                            }
                        }
                        $temp_arr = $_SESSION["sessions"][$this->current_page]["multi"][$table_field];
                        unset($_SESSION["sessions"][$this->current_page]["multi"][$table_field]);
                        foreach ($temp_arr as $key => $value) {
                            $_SESSION["sessions"][$this->current_page]["multi"][$table_field][] = $value;
                        }
                        //sort($_SESSION["sessions"][$this->current_page]["multi"][$table_field]);                        
                    }
                }
            }
        }
    }

    public function prepareHeaderFilter() {
        if (!isset($_SESSION["sessions"][$this->current_page]["header"])) {
            foreach ($this->form_data["fields"] as $field => $field_array) {
                $header = [];
                if (!isset($field_array["hide_table"])) {
                    $header["id"] = $field;
                    $header["name"] = $field_array["title"];
                    if (!isset($field_array["hidden"])) {
                        $header["selected"] = "";
                    }
                    $_SESSION["sessions"][$this->current_page]["header"][$field] = $header;
                }
            }
        }
    }

    public function prepareSearchFilter() {
        if (!isset($_SESSION["sessions"][$this->current_page]["search_filter"])) {
            foreach ($this->form_data["fields"] as $field => $field_array) {
                $header = [];
                if (!isset($field_array["hide_table"]) && !$this->isFiltered($field) && $field_array["type"] !== "date" && $field_array["type"] !== "datetime") {
                    $header["id"] = $field;
                    $header["name"] = $field_array["title"];
                    $header["selected"] = "";
                    $_SESSION["sessions"][$this->current_page]["search_filter"][$field] = $header;
                }
            }
        }
    }

    public function isSearchRemoved($field) {
        if (isset($_SESSION["sessions"][$this->current_page]["search_filter"])) {
            if (isset($_SESSION["sessions"][$this->current_page]["search_filter"][$field])) {
                $not_show = isset($_SESSION["sessions"][$this->current_page]["search_filter"][$field]["not_show"]);
                $not_selected = !isset($_SESSION["sessions"][$this->current_page]["search_filter"][$field]["selected"]);
                if ($not_show || $not_selected) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    public function isFiltered($field) {
        if (isset($_SESSION["sessions"][$this->current_page]["header"])) {
            if (isset($_SESSION["sessions"][$this->current_page]["header"][$field]["selected"])) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }

    protected function getFirstNonFiltered() {
        foreach ($_SESSION["sessions"][$this->current_page]["header"] as $key => $array) {
            if (isset($_SESSION["sessions"][$this->current_page]["header"][$key]["selected"])) {
                return $key;
            }
        }
    }

    public function setMultiFilter() {
        $values = $_POST['multi'];
        $field = $_POST['field'];
        if (isset($this->form_data["fields"][$field]["multi"])) {
            $table_field = $this->form_data["table_alias"][0] . "." . $this->form_data["fields"][$field]["field"];
            for ($i = 0; $i < count($_SESSION["sessions"][$this->current_page]["multi"][$table_field]); $i++) {
                if (array_search($_SESSION["sessions"][$this->current_page]["multi"][$table_field][$i]["id"], $values) !== false) {
                    $_SESSION["sessions"][$this->current_page]["multi"][$table_field][$i]["selected"] = "";
                } else {
                    unset($_SESSION["sessions"][$this->current_page]["multi"][$table_field][$i]["selected"]);
                }
            }
        }
        echo json_encode($this->prepareGUI());
    }

    public function setHeaderFilter() {
        $values = $_POST['header'];
        foreach ($_SESSION["sessions"][$this->current_page]["header"] as $key => $array) {
            if (array_search($key, $values) !== false) {
                $_SESSION["sessions"][$this->current_page]["header"][$key]["selected"] = "";
                if (isset($_SESSION["sessions"][$this->current_page]["search_filter"][$key])) {
                    if (isset($_SESSION["sessions"][$this->current_page]["search_filter"][$key]["not_show"])) {
                        unset($_SESSION["sessions"][$this->current_page]["search_filter"][$key]["not_show"]);
                        $_SESSION["sessions"][$this->current_page]["search_filter"][$key]["selected"] = "";
                    }
                }
                $table_field = $this->form_data["table"][0] . "." . $this->form_data["fields"][$key]["field"];
                $multi_set = isset($_SESSION["sessions"][$this->current_page]["multi"][$table_field]);
                if ($multi_set) {
                    if (isset($_SESSION["sessions"][$this->current_page]["multi"][$table_field][0]["not_show"])) {
                        unset($_SESSION["sessions"][$this->current_page]["multi"][$table_field][0]["not_show"]);
                        foreach ($_SESSION["sessions"][$this->current_page]["multi"][$table_field] as $index => $array) {
                            $_SESSION["sessions"][$this->current_page]["multi"][$table_field][$index]["selected"] = "";
                        }
                    }
                }
            } else {
                $_GET['remove_sort'] = $key;
                if (isset($_GET['remove_sort'])) {
                    $sort_key = array_search($_GET['remove_sort'], $_SESSION["sessions"][$this->current_page]['sort']);
                    unset($_SESSION["sessions"][$this->current_page]['sort'][$sort_key]);
                    unset($_SESSION["sessions"][$this->current_page]['order'][$_GET['remove_sort']]);
                    unset($_GET['remove_sort']);
                }
                if (isset($_SESSION["sessions"][$this->current_page]["search_filter"][$key])) {
                    $_SESSION["sessions"][$this->current_page]["search_filter"][$key]["not_show"] = "";
                    unset($_SESSION["sessions"][$this->current_page]["search_filter"][$key]["selected"]);
                }
                $table_field = $this->form_data["table"][0] . "." . $this->form_data["fields"][$key]["field"];
                if (isset($_SESSION["sessions"][$this->current_page]["multi"][$table_field])) {
                    $_SESSION["sessions"][$this->current_page]["multi"][$table_field][0]["not_show"] = "";
                }

                unset($_SESSION["sessions"][$this->current_page]["header"][$key]["selected"]);
            }
        }
        echo json_encode($this->prepareGUI());
    }

    public function setSearchFilter() {
        $values = $_POST['search'];
        foreach ($_SESSION["sessions"][$this->current_page]["search_filter"] as $key => $array) {
            if (array_search($key, $values) !== false) {
                $_SESSION["sessions"][$this->current_page]["search_filter"][$key]["selected"] = "";
            } else {
                unset($_SESSION["sessions"][$this->current_page]["search_filter"][$key]["selected"]);
            }
        }
        echo json_encode($this->prepareGUI());
    }

    public function removeMultiFilter() {
        $field = $_POST['field'];
        $table_field = $this->form_data["table_alias"][0] . "." . $this->form_data["fields"][$field]["field"];
        unset($_SESSION["sessions"][$this->current_page]["multi"][$table_field]);
        echo json_encode($this->prepareGUI());
    }

    protected function checkCondition($conditions, $object) {
//        "condition" => [
//                ["field" => "col1", "operation" => "exactly", "value" => "value for comparision"]
//            ]

        $passed = [];
        $join = [];
        foreach ($conditions as $condition) {
            $field = $condition["field"];
            $value = $condition["value"];
            $operation = $condition["operation"];

            if (isset($condition["join"])) {
                $join[] = $condition["join"];
            }

            switch ($operation) {
                case "=":
                    $passed[] = $object[$field] === $value ? true : false;
                    break;
                case "!=":
                    $passed[] = $object[$field] !== $value ? true : false;
                    break;
                case ">":
                    $passed[] = $object[$field] > $value ? true : false;
                    break;
                case ">=":
                    $passed[] = $object[$field] >= $value ? true : false;
                    break;
                case "<":
                    $passed[] = $object[$field] < $value ? true : false;
                    break;
                case "<=":
                    $passed[] = $object[$field] <= $value ? true : false;
                    break;
                case "contains":
                    $passed[] = stripos($object[$field], $value) !== false ? true : false;
                    break;
                case "not_contains":
                    $passed[] = stripos($object[$field], $value) === false ? true : false;
                    break;
                case "exactly":
                    $value = strtolower($value);
                    $object[$field] = strtolower($object[$field]);
                    $passed[] = $object[$field] === $value ? true : false;
                    break;
                default :
                    break;
            }
        }

        $is_passed = true;

        if (count($passed) > 1) {
            $is_passed &= $passed[0];
            for ($i = 1; $i < count($passed); $i++) {
                if ($join[$i - 1] === "AND") {
                    $is_passed &= $passed[$i];
                } else if ($join[$i - 1] === "OR") {
                    $is_passed |= $passed[$i];
                }
            }
        } else {
            $is_passed &= $passed[0];
        }
        return $is_passed;
    }

}
