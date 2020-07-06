<?php include_once '../includes/codecompiler.php'; ?>

<style>
    #code2{
        height:30px
    }
</style>

<h2> HTML Elements </h2>
<hr/>

<div>
    <h3>HTML Elements</h3>
    <p>An HTML element usually consists of a <strong>start</strong> tag and <strong>end</strong> tag, 
        with the content inserted in between:</p>

    <div style="font-size:20px;padding:10px;margin-bottom:10px;">
        <span style="color:brown"><span style="color:mediumblue">&lt;</span>tagname<span style="color:mediumblue">&gt;</span></span>Content goes here...<span style="color:brown"><span style="color:mediumblue">&lt;</span>/tagname<span style="color:mediumblue">&gt;</span></span>
    </div>

    <p>The HTML <strong>element</strong> is everything from the start tag to the end tag:</p>

    <div style="font-size:20px;padding:10px;margin-bottom:10px;">
        <span style="color:brown"><span style="color:mediumblue">&lt;</span>p<span style="color:mediumblue">&gt;</span></span>My first paragraph.<span style="color:brown"><span style="color:mediumblue">&lt;</span>/p<span style="color:mediumblue">&gt;</span></span>
    </div>

    <table class="table table-hover">
        <tbody>
            <tr>
                <th  class="text-left">Start tag</th>
                <th  class="text-left">Element content</th>
                <th  class="text-left">End tag</th>
            </tr>
            <tr>
                <td>&lt;h1&gt;</td>
                <td>My First Heading</td>
                <td>&lt;/h1&gt;</td>
            </tr>
            <tr>
                <td>&lt;p&gt;</td>
                <td>My first paragraph.</td>
                <td>&lt;/p&gt;</td>
            </tr>
            <tr>
                <td>&lt;br&gt;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        </tbody>
    </table>

    <blockquote> <p>HTML elements with no content are called empty elements. Empty elements do not have an end tag, such as the &lt;br&gt; 
            element (which indicates a line break).</p></blockquote>

</div>

<hr/>
<div>

    <h2>Nested HTML Elements</h2>
    <p>HTML elements can be nested (elements can contain elements).</p>
    <p>All HTML documents consist of nested HTML elements.</p>
    <p>This example contains four HTML elements:</p>

    <textarea id="code">
        <!DOCTYPE html>
        <html>
            <body>

                <h1>My First Heading</h1>
                <p>My first paragraph.</p>

            </body>
        </html></textarea>

    <button class="btn btn-success code-compiler">Code Compile</button>

    <h3>Example Explained</h3>
    <p>The <strong>&lt;html&gt;</strong> element defines the <strong>whole document</strong>.</p>
    <p>It has a <strong>start</strong> tag &lt;html&gt; and an <strong>end</strong> tag &lt;/html&gt;.</p>
    <p>The element <strong>content</strong> is another HTML element (the &lt;body&gt; element).</p>

    <textarea id="code1">
<html>
<body>

<h1>My First Heading</h1>
<p>My first paragraph.</p>

</body>
</html></textarea>
    <button class="btn btn-success code-compiler">Code Compile</button>

    <p>The <strong>&lt;body&gt;</strong> element defines the <strong>document body</strong>.</p>
    <p>It has a <strong>start</strong> tag &lt;body&gt; and an <strong>end</strong> tag &lt;/body&gt;.</p>
    <p>The element <strong>content</strong> is two other HTML elements (&lt;h1&gt; and &lt;p&gt;).</p>

    <textarea id="code2">
<p>My first paragraph.</p></textarea>

</div>

<hr/>
<div>
    <h2>Do Not Forget the End Tag</h2>
    <p>Some HTML elements will display correctly, even if you forget the end tag:</p>

    <textarea id="code3"> 
<html>
<body>

<p>This is a paragraph
<p>This is a paragraph

</body>
</html></textarea>
    <button class="btn btn-success code-compiler">Code Compile</button>
    <p>The example above works in all browsers, because the closing tag is considered optional. </p> 
    <p><strong>Never rely on this. It might produce unexpected results and/or errors if you forget the end tag.</strong></p>
</div>

<hr/>
<div>
    <h2>Empty HTML Elements</h2>
    <p>HTML elements with no content are called empty elements.</p>
    <p>&lt;br&gt; is an empty element without a closing tag (the &lt;br&gt; tag defines a line break).</p>
    <p>Empty elements can be "closed" in the opening tag like this: &lt;br /&gt;.</p>
    <p>HTML5 does not require empty elements to be closed. But if you want stricter 
        validation, or if you need to make your document readable by XML parsers, you 
        must close all HTML elements properly.</p>
</div>

<hr/>
<div>
    <h2>Use Lowercase Tags</h2>
    <p>HTML tags are not case sensitive: &lt;P&gt; means the same as &lt;p&gt;.</p>
    <p>The HTML5 standard does not require lowercase tags, but W3C
        <b>recommends</b> lowercase in HTML, and <b>demands</b> lowercase for stricter document types like XHTML.</p>

    <blockquote>
        <p>At W3Schools we always use lowercase tags.</p>
    </blockquote>  
</div>
<script>
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
</script>