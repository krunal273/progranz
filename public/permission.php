<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
checkLogin();
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once '../includes/head.php'; ?>
        <?php include_once '../includes/css.php' ?>
        <style>
            .list-group, .panel-group, .panel{
                margin-bottom: 0px;
            }

            .panel-body .col-md-6:first-child{
                padding-left: 0px;
            }

            .list-group:last-child{
                padding-right: 0px !important;
            }

            .col-sm-4{
                margin-bottom: 10px;
            }

            @media (max-width: 767px){
                .panel-body div[class*="col-"] + div[class*="col-"] {
                    padding: 0px !important;
                }
            }

        </style>
    </head>
    <body>
        <?php include_once '../includes/menu_top.php'; ?>
        <div class="container-fluid" id="main_container">
            <div class="row all_permission">
            </div>
        </div>
        <?php include_once '../includes/js.php'; ?>
        <script type="text/javascript" src="../js/permission.js<?php echo $random ?>"></script>
    </body>
</html>