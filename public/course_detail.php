<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
include_once '../classes/_database.php';
$db_object = new Database();
checkLogin();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Content2</title>

        <?php
        include_once '../includes/css.php';
        if (isset($_GET["type"])) {
            if ($_GET["type"] === "video") {
                echo "<link href='../css/video_course.css{$random}' rel='stylesheet'/>";
            }
        }
        if (isset($_GET["id"])) {
            $title = "";
            $folder = "";
            $topics = [];
            $query = "SELECT * FROM course_master WHERE id = {$_GET['id']}";
            $result = $db_object->find_by_sql($query);
            
            if (!empty($result)) {
                $result = array_shift($result);
                $title = $result["name"];
                $folder = $result["folder"];
                $user_id = $result['created_by'];            

                $query = "SELECT id, name, filename FROM course_topic_master WHERE course_id = {$_GET['id']} ORDER BY sequence";
                $topics = $db_object->find_by_sql($query);

                if (!isset($_GET['topic'])) {
                    $current_topic = $topics[0]["filename"];
                    $update_view = "UPDATE course_master SET view=view+1 WHERE id = {$_GET['id']}";
                    $update_result = $db_object->query($update_view);
                }

                if ($_GET["type"] === "video") {
                    $query = "SELECT id, video, title, description FROM video_master WHERE course_id = {$_GET['id']}";
                    $result = $db_object->find_by_sql($query);

                    $video_list = [];
                    $video_count = 0;
                    foreach ($result as $video) {
                        $video_list[$video["id"]] = $video;
                        if ($video_count === 0 && !isset($_GET['video'])) {
                            $_GET['video'] = $video["id"];
                        }
                    }

                    $video_path = "../docs/user_{$_SESSION['uid']}/course_{$_GET['id']}/videos/";
                    $video_file = $video_path . $video_list[$_GET['video']]["video"];
                }
            } else {
                $result = NULL;
            }
        }
        ?>
        <link href="../css/second.css" rel="stylesheet">
        <link href="../css/textpage.css" rel="stylesheet">

        <?php // include_once '../includes/font.php';  ?>

        <!--[if lt IE 9]>
          <script src="js/html5shiv.min.js"></script>
          <script src="js/respond.min.js"></script>
        <![endif]-->

    </head>
    <body>

        <?php include_once '../includes/menu_top.php'; ?>

        <?php
        if (isset($_GET["type"]))
            if ($_GET["type"] === "video") {
                require_once('../libraries/getID3/getid3/getid3.php');
                $getID3 = new getID3;
                include_once '../includes/video_course.php';
            } else if ($_GET["type"] === "text") {
                include_once '../includes/text_course.php';
            }
        ?>



        <!-- all js file-->
        <?php
        include_once '../includes/js.php';

        if (isset($_GET["type"])) {
            if ($_GET["type"] === "video") {
                echo "<script src='../js/video_course.js' type='text/javascript'></script>";
            }
        }
        ?>
        <script src="../js/second.js" type="text/javascript"></script>
        <script type="text/javascript">
            var course_id = <?php echo $_GET["id"];?>;
            var user_id = <?php echo $user_id;?>;
            $(document).on("click", ".material_button", function () {
                var fileExpand = $('#' + $(this).attr("data-target"));
                var buttonType = $(this).attr("data-type");
                var fileExpandType = fileExpand.attr("data-type");
                var path = $(this).attr("data-path");
                if (fileExpand.css("display") === "none") {
                    $('#' + $(this).attr("data-target")).show();
                    fileExpand.attr("data-type", buttonType);
                    showFileExpand(buttonType, path, fileExpand);
                } else {
                    if (buttonType === fileExpandType) {
                        $('#' + $(this).attr("data-target")).hide();
                    } else {
                        $('#' + $(this).attr("data-target")).show();
                        fileExpand.attr("data-type", buttonType);
                        showFileExpand(buttonType, path, fileExpand);
                    }
                }
            });

            function showFileExpand(folder, path, fileExpand) {
                $.ajax({
                    url: "../classes/" + current_page,
                    beforeSend: function () {
                        processing(true);
                    },
                    data: {
                        path: path,
                        folder: folder
                    },
                    type: "GET",
                    success: function (response) {
                        var json_ob = parseJSON(response);
                        if (json_ob !== false) {
                            displayFiles(folder, json_ob, fileExpand);
                        }
                    },
                    error: function (response) {
                        showAJAXError(response);
                    }
                });
            }

            function displayFiles(folder, json_ob, fileExpand) {
                var files = "<ul class='list-group'>";
                json_ob.sort();
                $.each(json_ob, function (i, v) {
                    files += "<li class='list-group-item'><a download target='_blank' href='../docs/user_"+user_id+"/course_"+course_id+"/"+folder+"/"+v+"'>" + v + "</a></li>";
                });

                files += "</ul>";
                fileExpand.html(files);
            }
        </script>
    </body>
</html>