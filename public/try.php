<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
include_once '../classes/user.php';
include_once '../classes/_database.php';
$db_object = new Database();
?>
<!DOCTYPE html>
<head>
    <?php include_once '../includes/head.php'; ?>
    <?php include_once '../includes/css.php'; ?>
    <link href="../css/owl.carousel.css" rel="stylesheet" type="text/css"/>
    <script src="../libraries/codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" href="../libraries/codemirror/lib/codemirror.css">
    <script src="../libraries/codemirror/mode/javascript/javascript.js"></script>
    <script src="../libraries/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="../libraries/codemirror/mode/xml/xml.js"></script>
    <script src="../libraries/codemirror/mode/css/css.js"></script>
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    <style>
        iframe, textarea{
            height:100%;
            width:100%;
        }

        .try, .CodeMirror {
            overflow:hidden;
            height:500px;
        }

        .row{
            margin: 10px 0 !important;
        }
    </style>
</head>
<body>
    <!--navbar start-->
    <?php
    include_once '../includes/menu_top.php';
    if (isset($_GET['path'])) {
        $_GET['path'] = str_replace("'", "", $_GET['path']);
        $_GET['path'] = str_replace("'", "", $_GET['path']);
        unset($_SESSION['filename']);
    }
    
    if (!isset($_SESSION['filename'])) {
        $filename = generateRandomString(5) . ".html";
        $_SESSION['filename'] = $filename;

        if (isset($_GET['path'])) {
            $file_contents = readCode($_GET['path']);
            $myfile = fopen("../try/" . $filename, "w") or die("Unable to open file!");
            fwrite($myfile, $file_contents);
            $myfile = fopen("../try/" . $filename, "r") or die("Unable to open file!");
            fwrite($myfile, $file_contents);
            if (filesize("../try/" . $filename) === 0) {
                $file_contents = "";
            } else {
                $file_contents = fread($myfile, filesize("../try/" . $filename));
            }
            fclose($myfile);
        } else {
            $myfile = fopen("../try/" . $filename, "w") or die("Unable to open file!");
            if (filesize("../try/" . $filename) === 0) {
                $file_contents = "";
            } else {
                $file_contents = fread($myfile, filesize("../try/" . $filename));
            }
            fclose($myfile);
        }
    } else {
        $filename = $_SESSION['filename'];
        $myfile = fopen("../try/" . $filename, "r") or die("Unable to open file!");
        if (filesize("../try/" . $filename) === 0) {
            $file_contents = "";
        } else {
            $file_contents = fread($myfile, filesize("../try/" . $filename));
        }
        fclose($myfile);
    }
    ?>
    <!--navbar end-->

    <div class='clearfix'></div>

    <div class="row">
        <form id='test_form'>
            <div class="col-md-6 try">
                <textarea id='code'><?php echo $file_contents; ?></textarea>
            </div>
            <div class="col-md-6 try">            
                <iframe src="../try/<?php echo $filename; ?>"></iframe>
            </div>
            <div class="col-md-6">
                <button class="btn btn-primary" type="button" id="test_code">Test Code</button>
            </div>        
        </form>

    </div>
    <?php include_once '../includes/js.php'; ?>
    <script src="../js/index.js" type="text/javascript"></script>
    <script type="text/javascript">
        myTextArea = document.getElementById("code");
        var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
            lineNumbers: true,
            mode: "htmlmixed"
        });
        myCodeMirror.mode = "html";

        var filename = "<?php echo $filename; ?>";
        $(document).on("click", "#test_code", function () {
            $.ajax({
                url: "../includes/test_code.php",
                beforeSend: function () {
                    processing(true);
                },
                data: {
                    code: myCodeMirror.getValue(),
                    filename: filename,
                    test: ""
                },
                type: "POST",
                success: function (response) {
                    var json_ob = parseJSON(response);
                    if (json_ob !== false) {
                        $("iframe").attr("src", "../try/" + filename);
                    }
                },
                error: function (response) {
                    showAJAXError(response);
                }
            });
        });
    </script>
</body>
</html>