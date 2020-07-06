<?php include_once '../includes/codecompiler.php'; ?>

<h1>HTML Introduction</span></h1>
<hr/>

<div>
    <h2>What is HTML?</h2>
    <p>HTML is the standard markup language for creating Web pages.</p>
    <ul>
        <li>HTML stands for Hyper Text Markup Language</li>
        <li>HTML describes the structure of Web pages using markup</li>
        <li>HTML elements are the building blocks of HTML pages</li>
        <li>HTML elements are represented by tags</li>
        <li>HTML tags label pieces of content such as "heading", "paragraph", "table", and so on</li>
        <li>Browsers do not display the HTML tags, but use them to render the content of the page</li>
    </ul>    
</div>

<hr/>
<div>
    <textarea id="code"><?php
        $file_path = $folder . "/htmlpro1.php";
        echo readCode($file_path);
        ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path; ?>">Code Compile!!!</a>

</div>

<hr/>
<div>
    <h3>Example Explained</h3>

    <ul>
        <li>The <code>&lt;!DOCTYPE html&gt;</code> declaration defines this document to be HTML5</li>
        <li>The <code>&lt;html&gt;</code> element is the root element of an HTML page</li>
        <li>The <code>&lt;head&gt;</code> element contains meta information about the document</li>
        <li>The <code>&lt;title&gt;</code> element specifies a title for the document</li>
        <li>The <code>&lt;body&gt;</code> element contains the visible page content</li>
        <li>The <code>&lt;h1&gt;</code> element defines a large heading</li>
        <li>The <code>&lt;p&gt;</code> element defines a paragraph</li>
    </ul>

</div>


<hr/>

<div>
    <h2>HTML Tags</h2>
    <p>HTML tags are element names surrounded by angle brackets:</p>

    <div class="well">&lt;tagname&gt;content goes here...&lt;/tagname&gt;</div>

    <ul>
        <li>HTML tags normally come <b>in pairs</b> like &lt;p&gt; and &lt;/p&gt;</li>
        <li>The first tag in a pair is the <b> start tag,</b> the second tag is the <b> end tag</b></li>
        <li>The end tag is written like the start tag, but with a <strong>forward slash</strong> inserted before the tag name </li>
    </ul>

    <uote> <strong>Tip:</strong> The start tablockqg is also called the <b>opening tag</b>, and the end tag the <b>closing tag</b>.</p> </blockquote>    
</div>
<hr/>

<div>
    <h2>Web Browsers</h2>
    <p>The purpose of a web browser (Chrome, IE, Firefox, Safari) is to read HTML documents and display them.</p>
    <p>The browser does not display the HTML tags, but uses them to determine how to display the document:</p>

    <img src="../../image/img_chrome.png" class="img-responsive img-thumbnail" alt="HTML DEMO">
</div>

<hr/>

<div>
    <h2>HTML Page Structure</h2>

    <p>Below is a visualization of an HTML page structure:</p>
    <img src="../../image/html-5-page-structure.jpg" class="img-responsive img-thumbnail" alt="HTML Page Structure">

</div>

<hr/>
<div>
    <h2>The &lt;!DOCTYPE&gt; Declaration</h2>
    <p>The &lt;!DOCTYPE&gt; declaration represents the document type, and helps browsers to display web pages correctly.</p>
    <p>It must only appear once, at the top of the page (before any HTML tags). </p>
    <p>The &lt;!DOCTYPE&gt; declaration is not case sensitive.</p>
    <p>The &lt;!DOCTYPE&gt; declaration for HTML is:</p>

    <div class="well"><span style="color:brown"><span style="color:mediumblue">&lt;</span>!DOCTYPE<span style="color:red"> html</span><span style="color:mediumblue">&gt;</span></span></div>

</div>
<div>
    <h2>HTML Versions</h2>
    <p>Since the early days of the web, there have been many versions of HTML:</p>
    <div class="col-sm-9">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Version</th>
                    <th>Year</th>
                </tr>
            </thead>
            <tbody class="text-center">
                <tr>
                    <td>HTML</td>
                    <td>1991</td>
                </tr>
                <tr>
                    <td>HTML 2.0</td>
                    <td>1995</td>
                </tr>
                <tr>
                    <td>HTML 3.2</td>
                    <td>1997</td>
                </tr>
                <tr>
                    <td>HTML 4.01</td>
                    <td>1999</td>
                </tr>
                <tr>
                    <td>XHTML</td>
                    <td>2000</td>
                </tr>
                <tr>
                    <td>HTML5</td>
                    <td>2014</td>
                </tr>
            </tbody>
        </table>
    </div>  
</div>

<hr/>
<script>
    myTextArea = document.getElementById("code");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
</script>