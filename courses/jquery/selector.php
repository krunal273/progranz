<?php include_once '../includes/codecompiler.php'; ?>

<h1>jQuery <span>Selectors</span></h1>
<hr/>

<div>
    <p>jQuery selectors are one of the most important parts of the jQuery library.</p>
</div>

<hr>

<div>
    <h2>jQuery Selectors</h2>
    <p>jQuery selectors allow you to select and manipulate HTML element(s).</p>
    <p>All selectors in jQuery start with the dollar sign and parentheses: $().</p>
</div>

<hr>

<div>
    <h2>The element Selector</h2>
    <p>The jQuery element selector selects elements based on the element name.</p>
    <p>You can select all &lt;p&gt; elements on a page like this:</p>

    <blockquote><div ><span style="color:black">
            <div>
                $(<span style="color:brown">"p"</span>)
            </div>
        </span></div></blockquote>
</div>
<p><b>Example</b></p>
<p>When a user clicks on a button, all &lt;p&gt; elements will be hidden:</p>

<div>
    <h3>Example</h3>

    <textarea id="code">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                    $(document).ready(function () {
                        $("button").click(function () {
                            $("p").hide();
                        });
                    });
                                                </script>
</head>
<body>

<h2>This is a heading</h2>

<p>This is a paragraph.</p>
<p>This is another paragraph.</p>

<button>Click me to hide paragraphs</button>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
</div>

<hr>

<div>
    <h2>The #id Selector</h2>
    <p>The jQuery #id selector uses the id attribute of an HTML tag to find the specific element.</p>
    <p>An id should be unique within a page, so you should use the #id selector when you want to find a single, unique element.</p>
    <p>To find an element with a specific id, write a hash character, followed by the id of the 
        HTML element:</p>

    <blockquote><div><span style="color:black">
            <div>
                $(<span style="color:brown">"#test"</span>)
            </div>
        </span></div></blockquote>
    <b>Example</b>
    <p>When a user clicks on a button, the element with id="test" will be hidden:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code1">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("button").click(function () {
                                $("#test").hide();
                            });
                        });
                    </script>
</head>
<body>

<h2>This is a heading</h2>

<p>This is a paragraph.</p>
<p id="test">This is another paragraph.</p>

<button>Click me</button>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>
</div>

<hr>

<div>
    <h2>The .class Selector</h2>
    <p>The jQuery class selector finds elements with a specific class.</p>
    <p>To find elements with a specific class, write a period character, followed by the name of the class:</p>

    <blockquote> <div><span style="color:black">
            <div>
                $(<span style="color:brown">".test"</span>)
            </div>
        </span></div></blockquote>

    <b>Example</b>
    <p>When a user clicks on a button, the elements with class="test" will be hidden:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code2">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("button").click(function () {
                                $(".test").hide();
                            });
                        });
                    </script>
</head>
<body>

<h2 class="test">This is a heading</h2>

<p class="test">This is a paragraph.</p>
<p>This is another paragraph.</p>

<button>Click me</button>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>
</div>

<hr>

<div>
    <h2>More Examples of jQuery Selectors</h2>
    <div>
        <table>
            <tbody><tr>
                    <th style="width:25%">Syntax</th>
                    <th style="width:65%">Description</th>
                </tr>
                <tr>
                    <td>$("*")</td>
                    <td>Selects all elements</td>
                </tr>
                <tr>
                    <td>$(this)</td>
                    <td>Selects the current HTML element</td>
                </tr>
                <tr>
                    <td>$("p.intro")</td>
                    <td>Selects all &lt;p&gt; elements with class="intro"</td>
                </tr>
                <tr>
                    <td>$("p:first")</td>
                    <td>Selects the first &lt;p&gt; element</td>
                </tr>
                <tr>
                    <td>$("ul li:first")</td>
                    <td>Selects the first &lt;li&gt; element of the first &lt;ul&gt;</td>
                </tr>
                <tr>
                    <td>$("ul li:first-child")</td>
                    <td>Selects the first &lt;li&gt; element of every &lt;ul&gt;</td>
                </tr>
                <tr>
                    <td>$("[href]")</td>
                    <td>Selects all elements with an href attribute</td>
                </tr>
                <tr>
                    <td>$("a[target='_blank']")</td>
                    <td>Selects all &lt;a&gt; elements with a target attribute value equal to "_blank"</td>
                </tr>
                <tr>
                    <td>$("a[target!='_blank']")</td>
                    <td>Selects all &lt;a&gt; elements with a target attribute value NOT equal to "_blank"</td>
                </tr>
                <tr>
                    <td>$(":button")</td>
                    <td>Selects all &lt;button&gt; elements and &lt;input&gt; elements of type="button"</td>
                </tr>
                <tr>
                    <td>$("tr:even")</td>
                    <td>Selects all even &lt;tr&gt; elements</td>
                </tr>
                <tr>
                    <td>$("tr:odd")</td>
                    <td>Selects all odd &lt;tr&gt; elements</td>
                </tr>
            </tbody></table>
    </div>

    <p>Use our <a target="_blank" href="trysel.asp">jQuery Selector Tester</a> to demonstrate the different selectors.</p>
    <p>For a complete reference of all the jQuery selectors, please go to our <a href="jquery_ref_selectors.asp">jQuery Selectors Reference</a>.</p>
</div>

<hr>

<div>
    <h2>Functions In a Separate File</h2>
    <p>If your website contains a lot of pages, and you want your jQuery functions to be easy 
        to maintain, you can put your jQuery functions in a separate .js file.</p>
    <p>When we demonstrate jQuery in this tutorial, the functions are added directly into the &lt;head&gt; 
        section. However, sometimes it is preferable to place them in a separate file, like this (use 
        the src attribute to refer 
        to the .js file): </p>
    
    <div>
        <div>
            <h3>Example</h3>
            <blockquote><div>
                <span style="color:brown"><span style="color:mediumblue">&lt;</span>head<span style="color:mediumblue">&gt;</span></span><br>
                <span style="color:brown"><span style="color:mediumblue">&lt;</span>script<span style="color:red">
                        src<span style="color:mediumblue">="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"</span></span><span style="color:mediumblue">&gt;</span></span><span style="color:black"><br>
                </span><span style="color:brown"><span style="color:mediumblue">&lt;</span>/script<span style="color:mediumblue">&gt;</span></span><br>
                <span><span style="color:brown"><span style="color:mediumblue">&lt;</span>script<span style="color:red"> src<span style="color:mediumblue">="my_jquery_functions.js"</span></span><span style="color:mediumblue">&gt;</span></span><span style="color:black"></span><span style="color:brown"><span style="color:mediumblue">&lt;</span>/script<span style="color:mediumblue">&gt;</span></span></span><br>
                <span style="color:brown"><span style="color:mediumblue">&lt;</span>/head<span style="color:mediumblue">&gt;</span></span>
            </div></blockquote>
            <br>
        </div>
        
    </div>
</div>
<hr>
</body>
<script type="text/javascript">
    myTextArea = document.getElementById("code");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    myTextArea = document.getElementById("code1");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    myTextArea = document.getElementById("code2");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    </script>