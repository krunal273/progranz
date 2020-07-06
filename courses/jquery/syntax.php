<?php include_once '../includes/codecompiler.php'; ?>

<h1>jQuery <span>Syntax</span></h1>

<hr/>

<div>
    <p>With jQuery you select (query) HTML elements and perform "actions" on them.</p>
</div>

<hr>

<div>
    <h2>jQuery Syntax</h2>
    <p>The jQuery syntax is tailor-made for <b>selecting</b> HTML elements and performing some <b>action</b> on the element(s).</p>
    <p>Basic syntax is: <b>$(<i>selector</i>).<i>action</i>()</b></p>
    <ul>
        <li>A $ sign to define/access jQuery</li>
        <li>A (<i>selector</i>) to "query (or find)" HTML elements</li>
        <li>A jQuery <i>action</i>() to be performed on the element(s)</li>
    </ul>

    <p>Examples:</p>
    <blockquote>
    <p>$(this).hide() - hides the current element.</p>
    <p>$("p").hide() - hides all &lt;p&gt; elements.</p>
    <p>$(".test").hide() - hides all elements with class="test".</p>
    <p>$("#test").hide() - hides the element with id="test".</p>
    </blockquote>
    <div>
        <p><b>Are you familiar with CSS selectors?</b><br><br>
            jQuery uses CSS syntax to select elements. You will learn more about the selector syntax in the next chapter of this tutorial.</p>
    </div>
</div>

<hr>

<h2>The Document Ready Event</h2>
<p>You might have noticed that all jQuery methods in our examples, are inside a document ready event:</p>

<div><span style="color:black">
        <blockquote>
        <div>
            $(document).<span style="color:black">ready</span>(<span style="color:mediumblue">function</span>(){<br><span style="color:red">
            </span><br>&nbsp;&nbsp; <i><span style="color:green">// jQuery methods go here...</span></i><br><br><span style="color:red">
            </span>});
        </div></blockquote>
    </span></div>

<p>This is to prevent any jQuery code from running before the document is finished loading (is ready).</p>
<p>It is good practice to wait for the document to be fully loaded and ready before working with it.
    This also allows you to have your JavaScript code before the body of your document, in the head section. </p>
<p>Here are some examples of actions that can fail if methods are run before the document is fully loaded:</p>
<ul>
    <li>Trying to hide an element that is not created yet</li>
    <li>Trying to get the size of an image that is not loaded yet</li>
</ul>
<blockquote>
<p><b>Tip:</b> The jQuery team has also created an even shorter method for the 
    document ready event:</p></blockquote>

<blockquote><div><span style="color:black">
        <div>
            $(<span style="color:mediumblue">function</span>(){<br><span style="color:red">
            </span><br>&nbsp;&nbsp; <i><span style="color:green">// jQuery methods go here...</span></i><br><br><span style="color:red">
            </span>});
        </div>
    </span></div>
</blockquote>

<p>Use the syntax you prefer. We think that the document ready event is easier to understand when reading the code.</p>