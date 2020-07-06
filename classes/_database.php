<?php

include_once "../includes/config.php";

class Database {

    protected $connection;

    function __construct() {
        $this->open_connection();
    }

    public function open_connection() {
        $this->connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
        if (mysqli_connect_errno()) {
            $this->stopScript("Database connection failed: ");
        }
    }

    protected function stopScript($message = "") {
        die($message . mysqli_connect_error() . " (" . mysqli_connect_errno() . ")");
    }

    public function close_connection() {
        if (isset($this->connection)) {
            mysqli_close($this->connection);
            unset($this->connection);
        }
    }

    public function find_all($condition = "") {
        if ($condition !== "") {
            $condition = " WHERE {$condition}";
        }
        return $this->find_by_sql("SELECT " . $this->getFields() . " FROM " . $this->getTables() . " {$condition}");
    }

    public function find_by_id($id = 0, $condition = "") {
        if ($condition !== "") {
            $condition = " AND {$condition}";
        }
        $query = "SELECT " . $this->getFields() . " FROM " . $this->getTables() . " WHERE " . $this->form_data["table_alias"][0] . ".id={$id} {$condition} LIMIT 1";
        $result_array = $this->find_by_sql($query);
        return !empty($result_array) ? array_shift($result_array) : false;
    }

    public function find_by_sql($query = "") {
        logAction("activities", "Find By SQL", $query);

        $result_set = $this->query($query);
        $row_array = array();
        while ($row = $this->fetch_array($result_set)) {
            $row_array[] = $row;
        }
        return $row_array;
    }

    public function query($query) {
        $result = mysqli_query($this->connection, $query);
        $this->confirm_query($result, $query);
        return $result;
    }

    private function confirm_query($result, $sql) {
        if (!$result) {
            $this->stopScript("Database query failed.<br>{$sql}");
        }
    }

    public function count_all($condition = "") {
        if ($condition !== "") {
            $condition = " WHERE {$condition}";
        }
        $sql = "SELECT COUNT(*) FROM " . $this->getTables() . " {$condition}";
        $result_set = $this->query($sql);
        $row = $this->fetch_array($result_set);
        return array_shift($row);
    }

    protected function getTables() {
        if (isset($this->form_data["join_type"])) {
            $tables = $this->form_data["table"][0] . " " . $this->form_data["table_alias"][0] . " ";
            $alias_main = $this->form_data["table_alias"][0];
            for ($i = 1; $i < count($this->form_data["table"]); $i++) {
                $join_type = $this->form_data["join_type"][$i - 1] . " JOIN ";
                $alias = $this->form_data["table_alias"][$i];
                $other_table = $this->form_data["table"][$i] . " " . $alias;
                $join_condition_left = $this->form_data["join_condition"][$i - 1][0];
                $join_condition_right = $this->form_data["join_condition"][$i - 1][1];
                $tables .= $join_type . " ";
                $tables .= $other_table . " ";
                $tables .= "ON ";
                $tables .= $alias_main . "." . $join_condition_left . "=" . $alias . "." . $join_condition_right . " ";
            }
            return $tables;
        } else {
            return $this->form_data["table"][0] . " " . $this->form_data["table_alias"][0];
        }
    }

    protected function getFields($edit = false, $array_name = "form_data") {
        $fields = array();
        $default_table = $this->$array_name["table_alias"][0];
        foreach ($this->$array_name["fields"] as $field => $field_array) {
            if ($field_array["field"] !== "NA") {
                if (isset($field_array["type"]) && !$this->isFiltered($field)) {
                    if ($field_array["type"] === "select" && !$edit) {
                        $table_field = $this->$array_name["table_alias"][$field_array["table"]] . "." . $field_array['foreign_field'];
                        $table_id_field = $default_table . "." . $field_array['field'];
                        $fields[] = "{$table_id_field} AS " . $field . "_id";
                    } else {
                        if (isset($field_array['foreign_field']) && isset($field_array["foreign_non_id"])) {
                            if (!$edit) {
                                $table_field = $this->$array_name["table_alias"][$field_array["table"]] . "." . $field_array['foreign_field'];
                            }
                        } else {
                            if (isset($field_array['foreign_field']) && $edit) {
                                $table_field = $this->$array_name["table_alias"][$field_array["table"]] . "." . $field_array['foreign_field'];
                                $fields[] = "{$table_field} AS " . $field . "_name";
                            }
                            $table_field = $default_table . "." . $field_array['field'];
                        }
                    }
                } else {
                    if (isset($field_array['foreign_field']) && isset($field_array["foreign_non_id"])) {
                        if (!$edit) {
                            $table_field = $this->$array_name["table_alias"][$field_array["table"]] . "." . $field_array['foreign_field'];
                        }
                    } else {
                        $table_field = $default_table . "." . $field_array['field'];
                    }
                }
                if (isset($field_array["has_null"])) {
                    $fields[] = "COALESCE({$table_field},'') AS {$field}";
                } else {
                    $fields[] = "{$table_field} AS {$field}";
                }
            }
        }
        $fields = implode(",", $fields);
        return $fields;
    }

    protected function getSearchQuery() {
        $fields = [];
        $default_table = $this->form_data["table_alias"][0];
        foreach ($this->form_data["fields"] as $field => $field_array) {
            if (!isset($field_array['hide_table']) && !isset($field_array['not_searchable']) && !$this->isFiltered($field) && !$this->isSearchRemoved($field)) {
                if ($field_array["type"] === "select") {
                    $table_name = $this->form_data["table_alias"][$field_array["table"]];
                    $fields[] = "{$table_name}.{$field_array['foreign_field']} like '%{$_SESSION["sessions"][$this->current_page]['search']}%'";
                } else {
                    $table_name = $default_table;
                    $fields[] = "{$table_name}.{$field_array['field']} like '%{$_SESSION["sessions"][$this->current_page]['search']}%'";
                }
            }
        }
        $fields = " AND (" . implode(" OR ", $fields) . ")";
        return $fields;
    }

    protected function isUnique($is_edit = false) {
        $unique = true;
        $unique_field_names = [];
        if (isset($this->form_data["constraints"])) {
            foreach ($this->form_data["constraints"] as $key => $value) {
                if ($key === "unique") {
                    $default_table = $this->form_data["table_alias"][0];
                    foreach ($value as $field) {
                        $field_array = $this->form_data["fields"][$field];
                        $escaped_value = $this->escape_value($_POST[$field]);
                        if ($field_array["type"] === "select") {
                            $unique_field_names[] = $field_array["title"] . " : " . $this->getSelectValue($escaped_value, $this->form_data["table"][$field_array["table"]]);
                        } else {
                            $unique_field_names[] = $field_array["title"] . " : " . $escaped_value;
                        }
                        $unique_fields[] = $default_table . "." . $field_array["field"] . "='{$escaped_value}'";
                    }
                    $unique = "SELECT " . $this->getFields() . " FROM " . $this->getTables() . " WHERE " . implode(" AND ", $unique_fields);

                    if ($is_edit) {
                        $unique .= " AND {$default_table}.id!='{$_POST['id']}'";
                    }
                    $object = $this->find_by_sql($unique);

                    $unique = count($object) ? false : true;

                    if (!$unique) {
                        $state = intval($object[0]["act"]);
                        $destroyed_data = $state === -1 ? ". its destroyed." : ($state === -2 ? ". its deactivated." : "");
                        $message = implode(" AND ", $unique_field_names);
                        $message = count($unique_field_names) > 1 ? $message . " combination " : $message;
                        $this->message = ["type" => "danger", "message" => "duplicate entry<br/>{$message}.<br/>{$destroyed_data}", "unique" => $this->form_data["constraints"]["unique"]];
                        echo json_encode($this->message);
                    }
                }
            }
        }
        return $unique;
    }

    private function getSelectValue($id, $table) {
        $query = "SELECT name from {$table} WHERE id={$id}";
        $result = $this->find_by_sql($query);
        return array_shift($result[0]);
    }

    protected function getQueryFieldsAndValues(&$fields, &$values, &$files) {

        $default_table = $this->form_data["table"][0];

        foreach ($this->form_data["fields"] as $field => $field_array) {
            if (isset($_FILES[$field])) {
//                $newname = renameExistingFile("../images/products", $field);
//                if ($newname !== false) {
//                    $fields[] = $default_table . "." . $field_array["field"];
//                    $values[] = "'" . $newname . "'";
//                    $files[$field] = $newname;
//                }

                if ($_FILES[$field]['name'] !== "") {
                    $fields[] = $default_table . "." . $field_array["field"];
                    $name = $_FILES[$field]['name'];
                    $actual_name = pathinfo($name, PATHINFO_FILENAME) . time();
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    $newname = $actual_name . "." . $extension;
                    $values[] = "'" . $newname . "'";
                    $files[$field] = $newname;
                    $_POST[$field . "_newname"] = $newname;
                }
            } else if (isset($_POST[$field])) {
                if (isset($field_array["has_null"])) {
                    $escaped_value = "NULL";
                } else {
                    if ($field_array["type"] === "date") {
                        $escaped_value = date("Y-m-d", strtotime($_POST[$field]));
                        $escaped_value = "'{$escaped_value}'";
                    } else if ($field_array["type"] === "datetime") {
                        $escaped_value = date("Y-m-d H:i:s", strtotime($_POST[$field]));
                        $escaped_value = "'{$escaped_value}'";
                    } else {
                        $escaped_value = "'" . $this->escape_value($_POST[$field]) . "'";
                    }
                }

                $fields[] = $default_table . "." . $field_array["field"];
                $values[] = $escaped_value;
            }
        }
    }

    public function insertData() {
        $unique = $this->isUnique();
        $query = "";

        if ($unique) {
            $fields = [];
            $values = [];
            $files = [];
            $default_table = $this->form_data["table"][0];
            $this->getQueryFieldsAndValues($fields, $values, $files);

            if (array_key_exists('c_by', $this->form_data["fields"])) {
                $fields[] = $default_table . ".created_by";
                $values[] = "'" . $_SESSION['uid'] . "'";
            }
            if (array_key_exists('c_date', $this->form_data["fields"])) {
                $fields[] = $default_table . ".created_date";
                $values[] = "'" . date("Y-m-d H:i:s") . "'";
            }

            $query = "INSERT INTO {$default_table} ";
            $query .= "(" . implode(",", $fields) . ")";
            $query .= " VALUES (" . implode(",", $values) . ")";

            $result = $this->query($this->insertQuery($default_table, $fields, $values));

            $add_other = "";

            if ($result) {
                $inserted_id = $this->insert_id();
                if (count($files) > 0) {
                    $this->uploadFiles($files, ["id" => $inserted_id]);
                }
                if (isset($_POST['other_page_col'])) {
                    $other_inserted_id = $this->insert_id();
                    $other_query = "SELECT " .
                            " id, {$this->form_data["fields"][$_POST['other_page_col']]["field"]} " .
                            " FROM " . $this->form_data["table"][0] . " " .
                            " WHERE {$this->form_data["table"][0]}.active = 1 ORDER BY {$this->form_data["fields"][$_POST['other_page_col']]["field"]}";
                    $other_result = $this->find_by_sql($other_query);
                    $add_other = ["data" => $other_result,
                        "selected" => $other_inserted_id,
                        "field" => $this->form_data["fields"][$_POST['other_page_col']]["field"]];
                }

                if (isset($other_inserted_id)) {
                    $this->message = ["type" => "success",
                        "message" => str_replace(' ', '', $this->form_data["title"]) . " successfully inserted",
                        "id" => $inserted_id,
                        "add_other" => $add_other,
                    ];
                } else {
                    $this->message = ["type" => "success",
                        "message" => str_replace(' ', '', $this->form_data["title"]) . " successfully inserted",
                        "id" => $inserted_id,
                        "gui" => $this->prepareGUI()
                    ];
                }
            } else {
                $this->message = setMessage("Error in inserting data", "danger");
            }
            echo json_encode($this->message);
        }

        logAction("activities", "Insert [" . $this->form_data["table"][0] . "][{$_SESSION['uname']} ({$_SESSION['uid']})] ", $query);
    }

    protected function insertQuery($default_table, $fields, $values) {
        $query = "INSERT INTO {$default_table} ";
        $query .= "(" . implode(",", $fields) . ")";
        $query .= " VALUES (" . implode(",", $values) . ")";

        return $query;
    }

    public function editData() {
        $unique = $this->isUnique(true);

        if ($unique) {

            $fields = [];
            $values = [];
            $files = [];
            $default_table = $this->form_data["table"][0];

            $this->getQueryFieldsAndValues($fields, $values, $files);

            $field_value = [];

            for ($i = 0; $i < count($fields); $i++) {
                $field_value[] = "{$fields[$i]}={$values[$i]}";
            }

            if (array_key_exists("u_by", $this->form_data["fields"])) {
                $field_value[] = "{$default_table}.updated_by='{$_SESSION['uid']}'";
            }

            if (array_key_exists("u_date", $this->form_data["fields"])) {
                $field_value[] = "{$default_table}.updated_date='" . date("Y-m-d H:i:s") . "'";
            }

            $field_value = implode(",", $field_value);
            $query = "UPDATE {$default_table} "
                    . "SET {$field_value} WHERE {$default_table}.id='{$_POST['id']}'";
            $this->query($query);
            if (count($files) > 0) {
                $this->uploadFiles($files, ["id" => $_POST['id'], "table" => $default_table], true);
            }
            $this->message = ["type" => "success",
                "message" => str_replace(' ', '', $this->form_data["title"]) . " successfully updated",
                "gui" => $this->prepareGUI(),
                "id" => $_POST['id']];
            echo json_encode($this->message);

            logAction("activities", "Edit [" . $this->form_data["table"][0] . "][{$_SESSION['uname']} ({$_SESSION['uid']})] ", $query);
        }
    }

    public function performOperation($ids) {
        $count_operation = 0;
        $operation = "";
        switch ($_POST['operation']) {
            case "activate":
            case "restore":
                $active = 1;
                $operation = "activated";
                break;
            case "delete":
                $active = 0;
                $operation = "deleted";
                break;
            case "destroy":
                $active = -1;
                $operation = "destroyed";
                break;
            case "deactivate":
                $active = -2;
                $operation = "deactivated";
                break;
            case "harddelete":
                $active = -3;
                $operation = "hard deleted";
                break;
            default :
                return;
        }

        $rows = [];
        foreach ($ids as $id) {
            if (isset($this->operations[$_POST['operation']]["condition"])) {
                $data_object = $this->find_by_id($id);
                if ($this->checkCondition($this->operations[$_POST['operation']]["condition"], $data_object)) {
                    $rows[] = "id='{$id}'";
                }
            } else {
                $rows[] = "id='{$id}'";
            }
        }

        $query = "";

        if (count($rows) > 0) {
            if ($active === -3) {
                $query = "DELETE FROM " . $this->form_data["table"][0] .
                        " WHERE " . implode(" OR ", $rows);
            } else {
                $query = "UPDATE " . $this->form_data["table"][0] .
                        " SET active = '{$active}' WHERE " . implode(" OR ", $rows);
            }

            $this->query($query);
            $count_operation += $this->affected_rows();
        }

        if ($count_operation > 0) {
            $this->message = ["type" => "success",
                "message" => "{$count_operation} " . str_replace("_", " ", str_replace(' ', '', $this->form_data["title"])) . " successfully {$operation}",
                "gui" => $this->prepareGUI()];
        } else {
            $this->message = setMessage("No operation performed", "danger");
        }
        echo json_encode($this->message);
        logAction("activities", ucwords($operation) . " [" . $this->form_data["table"][0] . "][{$_SESSION['uname']} ({$_SESSION['uid']})] ", $query);
    }

    public function escape_value($string) {
        return mysqli_real_escape_string($this->connection, $string);
    }

    public function fetch_array($result_set) {
        return mysqli_fetch_assoc($result_set);
    }

    public function num_rows($result_set) {
        return mysqli_num_rows($result_set);
    }

    public function insert_id() {
// get the last id inserted over the current db connection
        return mysqli_insert_id($this->connection);
    }

    public function affected_rows() {
        return mysqli_affected_rows($this->connection);
    }

}
