<!DOCTYPE html>
<title>Progranz-404</title>
<head>
    <?php include_once '../includes/head.php'; ?>
    <?php include_once '../includes/functions.php'; ?>
    <?php include_once '../includes/css.php'; ?>
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

    <style>
        .banner-404{
            font-size: 200px;
            margin-bottom: 0;
        }
        .m-t-25{
            margin-top: 25px;
        }
        .blink_me {
            animation: blinker 5s infinite;
        }

        @keyframes blinker {  
            50% { opacity: 0.5; }
        }
    </style>

</head>
<body>

    <!--navbar start-->
    <?php include_once '../includes/menu_top.php'; ?>
    <!--navbar end-->

    <div class='clearfix'></div>

    <br/>
    <div class="container">
        <h1 class="text-center">Oops <i class="fa fa-frown-o" aria-hidden="true"></i></h1>
        <h1 class="text-center banner-404 blink_me">404</h1>
        <h1 class="text-center">Page Not Found <i class="fa fa-exclamation-circle blink_me" aria-hidden="true"></i></h1>
        <h4 class="text-center m-t-25">Sorry, But the page you are looking for has not been found.Try checking the <code>URL</code> for error, then hit the refresh button on your browser.</h4>
    </div>


    <div class='divider line'><span><i class='fa fa-skyatlas'></i></span></div>

    <?php include_once '../includes/footer.php'; ?>

    <?php include_once '../includes/js.php'; ?>

</body>
</html>