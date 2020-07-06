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
        <style>
            video::-internal-media-controls-download-button {
                display:none;
            }

            video::-webkit-media-controls-enclosure {
                overflow:hidden;
            }

            video::-webkit-media-controls-panel {
                width: calc(100% + 30px); /* Adjust as needed */
            }
            video{
                width:95%;
            }
        </style>
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