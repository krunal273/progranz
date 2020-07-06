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
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <!--navbar start-->
    <?php include_once '../includes/menu_top.php'; ?>
    <!--navbar end-->

    <div class='clearfix'></div>

    <!-- feature carousel start-->
    <?php include_once '../includes/feature_carousel.php'; ?>
    <!-- feature carousel end-->

    <div class='clearfix'></div>
    <div class='divider line'><span><i class='fa fa-skyatlas'></i></span></div>

    <!-- list start-->
    <?php include_once '../includes/list_lang.php'; ?>
    <!-- list start-->

    <div class="clearfix"></div>

    <?php include_once '../includes/footer.php'; ?>
    <?php include_once '../includes/js.php'; ?>
    <script src="../js/index.js" type="text/javascript"></script>    
    <?php
    if (isset($_GET['activation_key'])) {
        $activated = activateUser($_GET['email'], $_GET['activation_key']);
        if ($activated) {
            $_SESSION['messagebag'][] = setMessage("Account activate. Please login");
        } else {
            $_SESSION['messagebag'][] = setMessage("User not found", "danger");
        }
        displayMessages();
    }
    ?>
</body>
</html>