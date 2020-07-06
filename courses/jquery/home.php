<?php include_once '../includes/codecompiler.php'; ?>

<h1>jQuery <span>Tutorial</span></h1>
<hr/>

<div>
    <p>jQuery is a JavaScript Library.</p>
    <p>jQuery greatly simplifies JavaScript programming.</p>
    <p>jQuery is easy to learn.</p>
</div>

<h2>"Try it Yourself" Examples in Each Chapter</h2>

<p>With our online editor, you can edit the code, and click on a button to view the result.</p>

<h3>Example</h3>
<div>
    <textarea id="code">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                    $(document).ready(function () {
                        $("p").click(function () {
                            $(this).hide();
                        });
                    });
</script>
</head>
<body>

<p>If you click on me, I will disappear.</p>
<p>Click me away!</p>
<p>Click me too!</p>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
</div>
</body>
<script type="text/javascript">
    myTextArea = document.getElementById("code");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
</script>


