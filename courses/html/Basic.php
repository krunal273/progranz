<?php include_once '../includes/codecompiler.php'; ?>

<h1>HTML Basic Examples</h1>
<hr/>

<div>
    <h2>HTML Documents</h2>

    <p>All HTML documents must start with a document type declaration: <strong>&lt;!DOCTYPE html&gt;</strong>.</p>
    <p>The HTML document itself begins with <strong>&lt;html&gt;</strong> and ends with <strong> &lt;/html&gt;</strong>.</p>
    <p>The visible part of the HTML document is between <strong>&lt;body&gt;</strong> and <strong>&lt;/body&gt;</strong>. </p>



    <textarea id="code"><?php
        $file_path = $folder . "/htmlpro1.php";
        echo readCode($file_path);
        ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path; ?>">Code Compile!!!</a>

</div>

<hr/>
<div>
    <h2>HTML Headings</h2>

    <p>HTML headings are defined with the <strong>&lt;h1&gt;</strong> to <strong>&lt;h6&gt;</strong> tags.</p>
    <p>&lt;h1&gt; defines the most important heading. &lt;h6&gt; defines the least important 
        heading:&nbsp;</p>

   <textarea id="code1"><?php
        $file_path = $folder . "/htmlpro2.php";
        echo readCode($file_path);
        ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path; ?>">Code Compile!!!</a>

</div>

<hr/>
<div>
    <h2>HTML Paragraphs</h2>

    <p>HTML paragraphs are defined with the <strong>&lt;p&gt;</strong> tag:</p>

    <textarea id="code2"><?php
        $file_path = $folder . "/htmlpro3.php";
        echo readCode($file_path);
        ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path; ?>">Code Compile!!!</a>

</div>

<hr/>
<div>
    <h2>HTML Links</h2>
    <p>HTML links are defined with the <strong>&lt;a&gt;</strong> tag:</p>
    <p>The link's destination is specified in the <strong>href attribute</strong>.&nbsp;</p>
    <p>Attributes are used to provide additional information about HTML elements.</p>

    <textarea id="code3"><?php
        $file_path = $folder . "/htmlpro4.php";
        echo readCode($file_path);
        ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path; ?>">Code Compile!!!</a>

</div>

<hr/>
<div>
    <h2>HTML Images</h2>
    <p>HTML images are defined with the <strong>&lt;img&gt;</strong> tag.</p>
    <p>The source file (src), alternative text (alt), 
        width, and height are provided as attributes:</p>

   <textarea id="code4"><?php
        $file_path = $folder . "/htmlpro5.php";
        echo readCode($file_path);
        ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path; ?>">Code Compile!!!</a>

</div>

<script>
    myTextArea = document.getElementById("code");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });

    myCodeMirror.mode = "html";
    myTextArea = document.getElementById("code1");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });

    myCodeMirror.mode = "html";
    myTextArea = document.getElementById("code2");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });

    myCodeMirror.mode = "html";
    myTextArea = document.getElementById("code3");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });

    myCodeMirror.mode = "html";
    myTextArea = document.getElementById("code4");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });

</script>