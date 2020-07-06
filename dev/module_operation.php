<?php

require_once('../includes/functions.php');
require_once('../classes/_database.php');

class Module_operation extends Database {

    public function addCommonOperations() {
        $query = "SELECT id FROM module_master WHERE active = 1";
        $modules = $this->find_by_sql($query);

        $query = "SELECT id FROM operation_master WHERE common LIKE 'common' AND active = 1";
        $operations = $this->find_by_sql($query);

        $count = 0;
        $fail = 0;
        foreach ($modules as $module) {
            $module_id = $module["id"];
            foreach ($operations as $operation) {
                $operation_id = $operation["id"];
                $query = "INSERT INTO "
                        . "module_operation_master "
                        . "(module_id, operation_id, created_by, created_date) "
                        . "VALUES "
                        . "('{$module_id}', '{$operation_id}', '{$_SESSION['uid']}', '" . date('Y-m-d H:i:s') . "')";
                $result = mysqli_query($this->connection, $query);
                if ($result) {
                    $count++;
                } else {
                    $fail++;
                }
            }
        }
        echo "Added : " . $count . "<br>";
        echo "Failed : " . $fail;
    }

}

$object = new Module_operation();
$object->addCommonOperations();
