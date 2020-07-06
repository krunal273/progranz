<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
checkLogin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once '../includes/head.php'; ?>
        <?php include_once '../includes/css.php'; ?>
    </head>
    <body>
        <?php include_once '../includes/menu_top.php'; ?>
        <div class="container-fluid" id="main_container">
        </div>
        <?php include_once '../includes/js.php'; ?>
        <script>
            $(document).ready(function () {
                getGUI("");
            });
        </script>
    </body>
</html>