<?php
include_once '../includes/config.php';
include_once '../includes/functions.php';
?>
<!DOCTYPE html>
<head>
    <?php include_once '../includes/head.php'; ?>
    <?php include_once '../includes/css.php'; ?>
    <script src="../libraries/ckeditor/ckeditor.js"></script>

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

    <div class="container-fluid">
        <div class="row mt_20">
            <div class="col-md-10 col-md-offset-1">
                <div class="container-fluid">
                    <div id="editor" class="row">
                        <form>
                            <textarea name="editor1" id="editor1" rows="10" cols="80">
                This is my textarea to be replaced with CKEditor.
                            </textarea>
                            <script>
                                CKEDITOR.replace('editor1', {
                                    // Define the toolbar groups as it is a more accessible solution.
                                    toolbarGroups: [
                                        {name: 'clipboard', groups: ['clipboard', 'undo']},
                                        {name: 'editing', groups: ['find', 'selection', 'spellchecker', 'editing']},
                                        {name: 'links', groups: ['links']},
                                        {name: 'insert', groups: ['insert']},
//                                        {name: 'forms', groups: ['forms']},
                                        {name: 'tools', groups: ['tools']},
//                                        {name: 'document', groups: ['mode', 'document', 'doctools']},
                                        {name: 'styles', groups: ['styles']},
//                                        {name: 'others', groups: ['others']},
                                        {name: 'basicstyles', groups: ['basicstyles', 'cleanup']},
                                        {name: 'paragraph', groups: ['list', 'indent', 'align', 'paragraph']},
//                                        {name: 'colors', groups: ['colors']},
//                                        {name: 'about', groups: ['about']}
                                    ],
                                    // Remove the redundant buttons from toolbar groups defined above.
                                    removeButtons: 'Underline,Strike,Subscript,Superscript,Anchor,Styles,Specialchar'
                                });

                            </script>
                        </form>
                    </div>

                </div>
            </div>


        </div>
    </div>
    <?php include_once '../includes/footer.php'; ?>
    <?php include_once '../includes/js.php'; ?>

</body>
</html>
