                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php include_once '../includes/codecompiler.php'; ?>

<div>
    <p>When a browser reads a style sheet, it will format the HTML document according to 
        the information in the style sheet.</p>
</div>
<hr>

<div>
    <h2>Three Ways to Insert CSS</h2>
    <p>There are three ways of inserting a style sheet:</p>
    <ul style="padding-top:8px;padding-bottom:8px">
        <li>External style sheet</li>
        <li>Internal style sheet</li>
        <li>Inline style</li>
    </ul>
</div>
<hr>

<div>
    <h2>External Style Sheet</h2>
    <p>With an
        external style sheet, you can change the look of an entire website by changing 
        just one file!</p>
    <p>Each page must include a reference to the external style sheet file inside the &lt;link&gt; 
        element. The &lt;link&gt; element goes inside the &lt;head&gt; section:</p>
    <textarea id="code"><?php 
    $file_path = $folder."/css_code2.php";
    echo readCode($file_path);
    ?></textarea>
    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path;?>">Code Compile!!!</a>
    <p>An external style sheet can be written in any text editor. The file should not contain any html tags. 
        The style sheet file must be saved with a .css extension.</p>
    <div>
        <blockquote><p><strong>Note:</strong> Do not add a space between the property value and the unit (such as <code>margin-left: 20 px;</code>). The correct way is: <code>margin-left: 20px;</code></p></blockquote>
    </div>
</div>
<hr>

<div>
    <h2>Internal Style Sheet</h2>
    <p>An internal style sheet may be used if one single page has a unique style.</p>
    <p>Internal styles are defined within the &lt;style&gt; element, inside the &lt;head&gt; section of an HTML page:</p>
    <textarea id="code1"><?php 
    $file_path = $folder."/css_code3.php";
    echo readCode($file_path);
    ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path;?>">Code Compile!!!</a>
</div>
<hr>

<div>
    <h2>Inline Styles</h2>
    <p>An inline style may be used to apply a unique style for a single element.</p>
    <p>To use inline styles, add the style attribute to the relevant element. The
        style attribute can contain any CSS property.</p>
    <p>The example below shows how to change
        the color and the left margin of a &lt;h1&gt; element:</p>
    <textarea id="code2">
<!DOCTYPE html>
<html>
<body>

<h1 style="color:blue;margin-left:30px;">This is a heading</h1>
<p>This is a paragraph.</p>

</body>
</html></textarea>
    
    <button class="btn btn-success">code compile</button>
    
    <div>
        <blockquote><p><strong>Tip:</strong> An inline style loses many of the advantages of a style sheet (by mixing
                content with presentation). Use this method sparingly.</p></blockquote>
    </div>
    
</div>
<hr>

<div>
    <h2>Multiple Style Sheets</h2>
    <p>If some properties have been defined for the same selector (element) in different style sheets,
        the value from the last read style sheet will be used.&nbsp;</p>
    <h3> Example</h3>
    <p> Assume that an external style sheet has the following 
        style for the &lt;h1&gt; element:</p>
    <textarea id="code3">
            <!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
<style>
                    h1 {
                        color: orange;
                    }
</style>
</head>
<body>

<h1>This is a heading</h1>
<p>The style of this document is a combination of an external stylesheet, and internal style</p>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
    <p>However, if the internal style is defined before the link to the external style sheet, the &lt;h1&gt; elements will be 
        "navy":</p>
    <form action="../../public/try.php" method="get">
        <textarea id="code4">
            <!DOCTYPE html>
<html>
<head>
<style>
                        h1 {
                            color: orange;
                        }
</style>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>

<h1>This is a heading</h1>
<p>The style of this document is a combination of an external stylesheet, and internal style</p>

</body>
</html></textarea>
    </form>
    <button type="submit" class="btn btn-success" formtarget="_blank">code compile</button>
</div>
<hr>

<div>
    <h2>Cascading Order</h2>
    <p>What style will be used when there is more than one style specified for an HTML element?</p>
    <p>Generally speaking we can say that all the styles will "cascade" into a new "virtual" style
        sheet by the following rules, where number one has the highest priority:</p>
    <ol>
        <li>Inline style (inside an HTML element)</li>
        <li>External and internal style sheets (in the head section)</li>
        <li>Browser default</li>
    </ol>
    <p>So, an inline style (inside a specific HTML element) has the highest priority, 
        which means that it will override a style defined inside the &lt;head&gt; tag, or in
        an external style sheet, or a browser default value.</p>
</div>


<script type="text/javascript">
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
