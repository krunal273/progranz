                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     <?php include_once '../includes/codecompiler.php'; ?>

<div>
    <h2>CSS Syntax</h2>
    <p>A CSS rule-set consists of a selector and a declaration block:</p>
    <p><img src="../../image/selector.gif" alt="CSS selector" class="w3-image"></p>
    <p>The selector points to the HTML element you want to style.</p>
    <p>The declaration block contains one or more declarations separated by semicolons.</p>
    <p>Each declaration includes a CSS property name and a value, separated by a colon.</p>
    <p>A CSS declaration always ends with a semicolon, and declaration blocks are surrounded by curly braces.</p>
    <p>In the following example all &lt;p&gt; elements will be center-aligned, with a red text color:</p>
    <textarea id="code">
<!DOCTYPE html>
<html>
<head>
<style>
                    p {
                        color: red;
                        text-align: center;
                    } 
</style>
</head>
<body>

<p>Hello World!</p>
<p>These paragraphs are styled with CSS.</p>

</body>
</html></textarea>
    
    <button class="btn btn-success">code compile</button>
</div>
<hr>

<div>
    <h2>CSS Selectors</h2>
    <p>CSS selectors are used to "find" (or select) HTML elements based on their element name, id, class, attribute, and more.</p>
</div>
<hr>

<div>
    <h2>The element Selector</h2>
    <p>The element selector selects elements based on the element name.</p>
    <p>You can select all &lt;p&gt; elements on a page like this (in this case, all &lt;p&gt; elements will be center-aligned, with a red text color):</p>
    <textarea id="code1">
<!DOCTYPE html>
<html>
<head>
<style>
                    p {
                        text-align: center;
                        color: red;
                    } 
</style>
</head>
<body>

<p>Every paragraph will be affected by the style.</p>
<p id="para1">Me too!</p>
<p>And me!</p>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
</div>
<hr>

<div>
    <h2>The id Selector</h2>
    <p>The id selector uses the id attribute of an HTML element to select a specific element.</p>
    <p>The id of an element should be unique within a page, so the id selector is 
        used to 
        select one unique element!</p>
    <p>To select an element with a specific id, write a hash (#) character, followed by 
        the id of the element.</p>
    <p>The style rule below will be applied to the HTML element with id="para1":</p>
    <textarea id="code2">
<!DOCTYPE html>
<html>
<head>
<style>
                    #para1 {
                        text-align: center;
                        color: red;
                    }
</style>
</head>
<body>

<p id="para1">Hello World!</p>
<p>This paragraph is not affected by the style.</p>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
</div>
<blockquote>
    <div>
        <p><strong>Note:</strong> An id name cannot start with a number!</p>
    </div>
</blockquote>
<hr>

<div>
    <h2>The class Selector</h2>
    <p>The class selector selects elements with a specific class attribute.</p>
    <p>To select elements with a specific class, write a period (.) character, followed by the name of the class.</p>
    <p>In the example below, all HTML elements with class="center" will be red and center-aligned:</p>
    <textarea id="code3">
<!DOCTYPE html>
<html>
<head>
<style>
                    .center {
                        text-align: center;
                        color: red;
                    }
</style>
</head>
<body>

<h1 class="center">Red and center-aligned heading</h1>
<p class="center">Red and center-aligned paragraph.</p> 

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
    <p>You can also specify that only specific HTML elements should be affected by a class.</p>
    <p>In the example below, only &lt;p&gt; elements with class="center" will be center-aligned:</p>
  
    <textarea id="code4">
<!DOCTYPE html>
<html>
<head>
<style>
                    p.center {
                        text-align: center;
                        color: red;
                    }
</style>
</head>
<body>

<h1 class="center">This heading will not be affected</h1>
<p class="center">This paragraph will be red and center-aligned.</p> 

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
    <blockquote><p><strong>Note:</strong> A class name cannot start with a number!</p></blockquote>
</div>
<hr>

<div>
    <h2>Grouping Selectors</h2>
    <p>If you have elements with the same style definitions, like this:</p>
    <p>It will be better to group the selectors, to minimize the code.</p>
    <p>To group selectors, separate each selector with a comma.</p>
    <p>In the example below we have grouped the selectors from the code above:</p>
    <textarea id="code5">
<!DOCTYPE html>
<html>
<head>
<style>
                    h1, h2, p {
                        text-align: center;
                        color: red;
                    }
</style>
</head>
<body>

<h1>Hello World!</h1>
<h2>Smaller heading!</h2>
<p>This is a paragraph.</p>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
</div>
<hr>

<div>
    <h2>CSS Comments</h2>
    <p>Comments are used to explain the code, and may help when you edit the source code at a later date.</p>
    <p>Comments are ignored by browsers.</p>
    <p>A CSS comment starts with /* and ends with */. Comments can also span lines:</p>
    <textarea id="code6">
<!DOCTYPE html>
<html>
<head>
<style>
                    p {
                        color: red;
                        /* This is a single-line comment */
                        text-align: center;
                    } 

                    /* This is
                    a multi-line
                    comment */
</style>
</head>
<body>

<p>Hello World!</p>
<p>This paragraph is styled with CSS.</p>
<p>CSS comments are not shown in the output.</p>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
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
    
    myCodeMirror.mode = "html";
    myTextArea = document.getElementById("code5");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    
    myCodeMirror.mode = "html";
    myTextArea = document.getElementById("code6");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
</script>