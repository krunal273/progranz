<?php

include_once "../includes/functions.php";
include_once "../classes/_database.php";
include_once "../classes/_gui.php";

class Permission extends GUI {

    private $module_filter, $usertype_filter, $operation_filter;

    public function __construct() {
        parent::__construct();

        $this->module_filter = "";
        $this->usertype_filter = "";

//        if ($_SESSION['utype_name'] !== "developer") {
//            $this->module_filter = " AND module_master.dev_only = 0 ";
//        }
//
//        if ($_SESSION['utype_name'] !== "developer") {
//            $this->usertype_filter = " AND usertype_master.name not like 'developer' ";
//        }
    }

    public function deletePermission() {
        $id = $_GET['delete_permission'];

        if ($_SESSION['utype'] !== $id) {
            $main_table = "category_permission_master";
            $query = "DELETE FROM {$main_table} WHERE usertype_id = {$id}";
            $result = $this->query($query);

            $main_table = "operation_permission_master";
            $query = "DELETE FROM {$main_table} WHERE usertype_id = {$id}";
            $result = $this->query($query);
            echo json_encode(setMessage("permission successfully deleted"));
        } else {
            echo json_encode(["type" => "danger", "message" => "permission successfully deleted"]);
        }
    }

    public function setPermission() {
        $usertype = $_GET['usertype'];
        $modules = $_GET["set_permissions"];
        if ($_GET["category"] === "none") {
            $categories = [];
        } else {
            $categories = $_GET["category"];
        }
        if ($_GET["operation"] === "none") {
            $operations = [];
        } else {
            $operations = $_GET["operation"];
        }

        $find_modules = [];
        foreach ($modules as $id) {
            $find_modules[] = "module_id='{$id}'";
        }
        $find_modules = " AND " . implode(" OR ", $find_modules);

        $main_table = "category_permission_master";
        $query = "SELECT "
                . "id, category_id AS category, module_id AS module "
                . "FROM "
                . "{$main_table} "
                . "WHERE "
                . "usertype_id = {$usertype}";
        $permitted_categories = $this->find_by_sql($query);

        foreach ($modules as $module) {
            foreach ($categories as $category) {
                if (!$this->searchPermitted($module, $category, $permitted_categories, "category")) {
                    $query = ""
                            . "INSERT INTO "
                            . "{$main_table} "
                            . "(usertype_id, module_id, category_id, created_by, created_date) "
                            . "VALUES "
                            . "({$usertype}, {$module}, {$category}, '{$_SESSION['uid']}', '" . date('Y-m-d H:i:s') . "') ";

                    $result = $this->query($query);
                }
            }
        }

        $delete = $this->searchToDelete($modules, $categories, $permitted_categories, "category");

        if (count($delete) > 0) {
            $rows = [];
            foreach ($delete as $id) {
                $rows[] = "id='{$id}'";
            }
            $rows = implode(" OR ", $rows);

            $query = "DELETE FROM {$main_table} WHERE {$rows} {$find_modules}";
            $result = $this->query($query);
        }

        $main_table = "operation_permission_master";
        $query = "SELECT "
                . "id, operation_id AS operation, module_id AS module "
                . "FROM "
                . "{$main_table} "
                . "WHERE "
                . "usertype_id = {$usertype}";
        $permitted_operations = $this->find_by_sql($query);

        foreach ($modules as $module) {
            foreach ($operations as $operation) {
                if (!$this->searchPermitted($module, $operation, $permitted_operations, "operation")) {

                    $query = "SELECT * FROM module_operation_master WHERE module_id = {$module} AND operation_id = {$operation} AND active = 1 ";
                    $result = $this->find_by_sql($query);

                    if (count($result) > 0) {
                        $query = ""
                                . "INSERT INTO "
                                . "{$main_table} "
                                . "(usertype_id, module_id, operation_id, created_by, created_date) "
                                . "VALUES "
                                . "({$usertype}, {$module}, {$operation}, '{$_SESSION['uid']}', '" . date('Y-m-d H:i:s') . "') ";

                        $result = $this->query($query);
                    }
                }
            }
        }

        $delete = $this->searchToDelete($modules, $operations, $permitted_operations, "operation");

        if (count($delete) > 0) {
            $rows = [];
            foreach ($delete as $id) {
                $rows[] = "id='{$id}'";
            }
            $rows = implode(" OR ", $rows);
            $query = "DELETE FROM {$main_table} WHERE {$rows} {$find_modules}";
            $result = $this->query($query);
        }

        $this->getPermission($modules, $usertype);
    }

    public function searchPermitted($module, $category, $permitted, $key) {
        foreach ($permitted as $permitted_data) {
            if ($permitted_data[$key] === $category && $permitted_data["module"] === $module) {
                return true;
            }
        }
        return false;
    }

    public function searchToDelete($modules, $key_array, $permitted, $key) {
        $delete = [];

        if (count($key_array) !== 0) {
            foreach ($permitted as $permitted_data) {
                $key_found = in_array($permitted_data[$key], $key_array);
                $module_found = in_array($permitted_data["module"], $modules);
                if ($key_found === false && $module_found === true) {
                    $delete[] = $permitted_data['id'];
                }
            }
        } else {
            foreach ($permitted as $permitted_data) {
                $module_found = in_array($permitted_data["module"], $modules);
                if ($module_found === true) {
                    $delete[] = $permitted_data['id'];
                }
            }
        }

        return $delete;
    }

    public function getPermittedCategory($module, $usertype) {

        foreach ($module as &$value) {
            $value = "category_permission_master.module_id = '{$value}'";
        }
        unset($value);

        $module_condition = " AND (" . implode($module, " OR ") . ")";

        $query = "SELECT "
                . "category_id "
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
                . "category_permission_master.usertype_id = {$usertype} "
                . $this->module_filter
                . $this->usertype_filter
                . $module_condition;
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function getPermittedOperation($module, $usertype) {

        foreach ($module as &$value) {
            $value = "operation_permission_master.module_id = '{$value}'";
        }
        unset($value);

        $module_condition = " AND (" . implode($module, " OR ") . ")";

        $query = "SELECT "
                . "operation_id "
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
                . "operation_permission_master.usertype_id = {$usertype} "
                . $this->module_filter
                . $this->usertype_filter
                . $module_condition;
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function getModuleOperations($module) {

        foreach ($module as &$value) {
            $value = "module_id = '{$value}'";
        }
        unset($value);

        $module_condition = " AND (" . implode($module, " OR ") . ")";

        $query = "SELECT "
                . "DISTINCT "
                . "operation_master.id AS id, "
                . "operation_master.name AS name,  "
                . "operation_master.common AS common "
                . "FROM "
                . "module_operation_master, module_master, operation_master "
                . "WHERE "
                . "module_operation_master.active = 1 AND "
                . "module_master.active = 1 AND "
                . "operation_master.active = 1 AND "
                . "module_operation_master.module_id = module_master.id AND "
                . "module_operation_master.operation_id = operation_master.id "
                . "{$module_condition} "
                . $this->module_filter
                . "ORDER BY operation_master.sequence ";
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function getPermission($module, $usertype) {
        $categories = $this->getPermittedCategory($module, $usertype);
        $operations = $this->getPermittedOperation($module, $usertype);
        $module_operation = $this->getModuleOperations($module);
        $permissions = ["category" => $categories, "operation" => $operations, "module_operation" => $module_operation];
        echo json_encode($permissions);
    }

    public function getAllPermission() {
        $permissions = [];

        $query = "SELECT id, name FROM usertype_master WHERE active = 1 {$this->usertype_filter} ORDER BY name";
        $usertypes = $this->query($query);

        $query = "SELECT id, REPLACE(display_name,'_',' ') AS name FROM module_master WHERE active = 1 {$this->module_filter} ORDER BY name";
        $modules = $this->query($query);

        foreach ($usertypes as $usertype) {
            $permissions[$usertype["name"]]["id"] = $usertype["id"];
            $permissions[$usertype["name"]]["name"] = $usertype["name"];
            if ($_SESSION['utype'] === $usertype["id"]) {
                $permissions[$usertype["name"]]["same"] = "";
            }

            foreach ($modules as $module) {
                $permissions[$usertype["name"]]["module"][$module["name"]]["id"] = $module["id"];
                $permissions[$usertype["name"]]["module"][$module["name"]]["name"] = $module["name"];

                $query = "SELECT "
                        . "category_id, category_master.name as name "
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
                        . "category_permission_master.usertype_id = {$usertype["id"]} AND "
                        . "module_master.id  = {$module["id"]} "
                        . "ORDER BY module_master.name ASC, category_master.sequence ASC ";
                $result = $this->find_by_sql($query);
                $permissions[$usertype["name"]]["module"][$module["name"]]["category"] = $result;

                $query = "SELECT "
                        . "operation_id, operation_master.name as name "
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
                        . "operation_permission_master.usertype_id = {$usertype["id"]} AND "
                        . "module_master.id  = {$module["id"]} "
                        . "ORDER BY module_master.name ASC, operation_master.sequence ASC ";
                $result = $this->find_by_sql($query);
                $permissions[$usertype["name"]]["module"][$module["name"]]["operation"] = $result;
            }
        }

        echo json_encode($permissions);
    }

    public function getCategories1() {
        $query = "SELECT "
                . "id, name "
                . "FROM "
                . "category_master "
                . "WHERE "
                . "active = 1 "
                . "ORDER BY sequence ";
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function getOperations() {
        $query = "SELECT "
                . "id, name, common "
                . "FROM "
                . "operation_master "
                . "WHERE "
                . "active = 1 AND common='common' "
                . "ORDER BY sequence ";
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function getModules() {
        $query = "SELECT "
                . "id, REPLACE(display_name,'_',' ') AS name "
                . "FROM "
                . "module_master "
                . "WHERE "
                . "active = 1 "
                . $this->module_filter
                . "ORDER BY name ";
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function getUsertype() {

        $query = "SELECT "
                . "id, name "
                . "FROM "
                . "usertype_master "
                . "WHERE "
                . "active = 1 "
                . $this->usertype_filter
                . "ORDER BY name ";
        $result = $this->find_by_sql($query);
        return $result;
    }

    public function getPermissionData() {
        $data = [];
        $data["module"] = $this->getModules();
        $data["category"] = $this->getCategories1();
        $data["usertype"] = $this->getUsertype();
        $data["operation"] = $this->getOperations();
        echo json_encode($data);
    }

}

$object = new Permission();

if (isset($_GET['module_operation'])) {
    $object->getModuleOperations($_GET['module_operation']);
} else if (isset($_GET['permission_data'])) {
    $object->getPermissionData($_GET['permission_data']);
} else if (isset($_GET['get_operations'])) {
    if ($_GET['get_operations'] !== "none") {
        echo json_encode($object->getModuleOperations($_GET['get_operations']));
    } else {
        echo json_encode($object->getOperations());
    }
} else if (isset($_GET['get_permissions'])) {
    if ($_GET['get_permissions'] !== "none" && intval($_GET['usertype']) !== -1) {
        $object->getPermission($_GET['get_permissions'], $_GET['usertype']);
    }
} else if (isset($_GET['get_all_permissions'])) {
    $object->getAllPermission();
} else if (isset($_GET['set_permissions'])) {
    if ($_GET['set_permissions'] !== "none" && intval($_GET['usertype']) !== -1) {
        $object->setPermission();
    }
} else if (isset($_GET['delete_permission'])) {
    $object->deletePermission();
} 