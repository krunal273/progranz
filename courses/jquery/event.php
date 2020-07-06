<?php include_once '../includes/codecompiler.php'; ?>

<h1>jQuery <span>Event Methods</span></h1>

<hr>

<div>
    <p>jQuery is tailor-made to respond to events in an HTML page.</p>
</div>

<hr>

<div>
    <h2>What are Events?</h2>
    <p>All the different visitor's actions that a web page can respond to are called events.</p>
    <p>An event represents the precise moment when something happens.</p>
    <p>Examples:</p>

    <ul>
        <li>moving a mouse over an element</li>
        <li>selecting a radio button</li>
        <li>clicking on an element</li>
    </ul>

    <p>The term <b>"fires/fired"</b> is often used with events. Example: 
        "The keypress event is fired, the moment you press a key".</p>
    <p>Here are some common DOM events:</p>

    <div>
        <table class="table table-hover">
            <tbody><tr>
                    <th class="text-left" style="width:23%">Mouse Events</th>
                    <th class="text-left" style="width:25%">Keyboard Events</th>
                    <th class="text-left" style="width:22%">Form Events</th>
                    <th class="text-left">Document/Window Events</th>
                </tr>
                <tr>
                    <td>click</td>
                    <td>keypress</td>
                    <td>submit</td>
                    <td>load</td>
                </tr>
                <tr>
                    <td>dblclick</td>
                    <td>keydown</td>
                    <td>change</td>
                    <td>resize</td>
                </tr>
                <tr>
                    <td>mouseenter</td>
                    <td>keyup</td>
                    <td>focus</td>
                    <td>scroll</td>
                </tr>
                <tr>
                    <td>mouseleave</td>
                    <td>&nbsp;</td>
                    <td>blur</td>
                    <td>unload</td>
                </tr>
            </tbody></table>
    </div>
</div>

<hr>

<div>

    <h2>jQuery Syntax For Event Methods</h2>
    <p>In jQuery, most DOM events have an equivalent jQuery method.</p>
    <p>To assign a click event to all paragraphs on a page, you can do this: </p>

    <blockquote><div><span style="color:black">
                <div>
                    $(<span style="color:brown">"p"</span>).<span style="color:black">click</span>();
                </div>
            </span></div>

        <div><span style="color:black">
                <div>
                    $(<span style="color:brown">"p"</span>).<span style="color:black">click</span>(<span style="color:mediumblue">function</span>(){<br><span style="color:red">
                    </span>&nbsp; <span style="color:green">// action goes here!!<br></span><span style="color:red">
                    </span>});
                </div>
            </span></div></blockquote>
</div>

<hr>

<div>
    <h2>Commonly Used jQuery Event Methods</h2>
    <p><b>$(document).ready()</b></p>
    <p>The $(document).ready() method allows us to execute a function when the 
        document is fully loaded. This event is already explained in the
        <a href="jquery_syntax.asp">jQuery Syntax</a> chapter. </p
    <p><b>click()</b></p>
    <p>The click() method attaches an event handler function to an HTML element.</p>
    <p>The 
        function is executed when the user clicks on the HTML element.</p>
    <p>The following example says: When a click event fires on a &lt;p&gt; element; hide 
        the current &lt;p&gt; element:</p>

    <div>
        <h3>Example</h3>
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

    <p><b>dblclick()</b></p>
    <p>The dblclick() method attaches an event handler function to an HTML element.</p>
    <p>The function is executed when the user double-clicks on the HTML element:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code1">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("p").dblclick(function () {
                                $(this).hide();
                            });
                        });
                    </script>
</head>
<body>

<p>If you double-click on me, I will disappear.</p>
<p>Click me away!</p>
<p>Click me too!</p>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>

    <p><b>mouseenter()</b></p>
    <p>The mouseenter() method attaches an event handler function to an HTML 
        element.</p>
    <p>The function is executed when the mouse pointer enters the HTML element:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code2">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("#p1").mouseenter(function () {
                                alert("You entered p1!");
                            });
                        });
                    </script>
</head>
<body>

<p id="p1">Enter this paragraph.</p>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>

    <p><b>mouseleave()</b></p>
    <p>The mouseleave() method attaches an event handler function to an HTML 
        element.</p>
    <p>The function is executed when the mouse pointer leaves the HTML element:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code3">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("#p1").mouseleave(function () {
                                alert("Bye! You now leave p1!");
                            });
                        });
                    </script>
</head>
<body>

<p id="p1">This is a paragraph.</p>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>

    <p><b>mousedown()</b></p>
    <p>The mousedown() method attaches an event handler function to an HTML 
        element.</p>
    <p>The function is executed, when the left, middle or right mouse button is pressed down, while the 
        mouse is over the HTML element:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code4">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("#p1").mousedown(function () {
                                alert("Mouse down over p1!");
                            });
                        });
                    </script>
</head>
<body>

<p id="p1">This is a paragraph.</p>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>

    <p><b>mouseup()</b></p>
    <p>The mouseup() method attaches an event handler function to an HTML 
        element.</p>
    <p>The function is executed, when the left, middle or right mouse button is released, while the 
        mouse is over the HTML element:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code5">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("#p1").mouseup(function () {
                                alert("Mouse up over p1!");
                            });
                        });
                    </script>
</head>
<body>

<p id="p1">This is a paragraph.</p>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>

    <p><b>hover()</b></p>
    <p>The hover() method takes two functions and is a combination of the mouseenter() and mouseleave() 
        methods.</p>
    <p>The first 
        function is executed when the mouse enters the HTML element, and the second 
        function is 
        executed when the mouse leaves the HTML element:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code6">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("#p1").hover(function () {
                                alert("You entered p1!");
                            },
                                    function () {
                                        alert("Bye! You now leave p1!");
                                    });
                        });
                    </script>
</head>
<body>

<p id="p1">This is a paragraph.</p>

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>

    <p><b>focus()</b></p>
    <p>The focus() method attaches an event handler function to an HTML form field.</p>
    <p>The function is executed when the form field gets focus:</p>

    <div>
        <h3>Example</h3>
        <textarea id="code7">
<!DOCTYPE html>
<html>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
                        $(document).ready(function () {
                            $("input").focus(function () {
                                $(this).css("background-color", "#cccccc");
                            });
                            $("input").blur(function () {
                                $(this).css("background-color", "#ffffff");
                            });
                        });
                    </script>
</head>
<body>

Name: <input type="text" name="fullname"><br>
Email: <input type="text" name="email">

</body>
</html></textarea>
        <button class="btn btn-success">code compile</button>
    </div>
</div>

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
    myTextArea = document.getElementById("code3");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    myTextArea = document.getElementById("code4");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    myTextArea = document.getElementById("code5");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    myTextArea = document.getElementById("code6");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    myTextArea = document.getElementById("code7");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
</script>