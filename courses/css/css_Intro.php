<?php include_once '../includes/codecompiler.php'; ?>
<?php include_once '../includes/functions.php'; ?>

<div>
    <h2>What is CSS?</h2>
    <ul>
        <li><b>CSS</b> stands for <b>C</b>ascading <b>S</b>tyle <b>S</b>heets</li>
        <li>CSS describes <strong>how HTML elements are to be displayed on screen,  
                paper, or in other media</strong></li>
        <li>CSS <strong>saves a lot of work</strong>. It can control the layout of 
            multiple web pages all at once</li>
        <li>External stylesheets are stored in <b>CSS files</b></li>
    </ul>

</div>

<hr>
<div>
    <h2>CSS Demo - One HTML Page - Multiple Styles!</h2>
    <p>Here we will show one HTML page displayed with four different stylesheets. 
        Click on the "Stylesheet 1", "Stylesheet 2", "Stylesheet 3", "Stylesheet 4" 
        links below to see the different styles:</p>
</div>

<div>
	
    <textarea id="code"><?php 
    $file_path = $folder."/css_code1.php";
    echo readCode($file_path);
    ?></textarea>

    <a class="btn btn-success" href="../public/try.php?path='<?php echo $file_path;?>">Code Compile!!!</a>
</div>
<hr>
<div>
    <h2>Why Use CSS?</h2>
    <p>CSS is used to define styles for your web pages, including the design, layout 
        and variations in display for different devices and screen sizes.&nbsp;
    </p>
    <hr>
    <h2>CSS Solved a Big Problem</h2>
    <p>HTML was NEVER intended to contain tags for formatting a web page!</p>
    <p>HTML was created to <strong>describe the content</strong> of a web page, like:</p>
    <p>&lt;h1&gt;This is a heading&lt;/h1&gt;</p>
    <p>&lt;p&gt;This is a paragraph&lt;/p&gt;</p>
    <p>When tags like &lt;font&gt;, and color attributes were added to the HTML 3.2 
        specification, it started a nightmare for web developers. Development of large 
        websites, where fonts and color information were added to every single  
        page, became a long and expensive process.</p>
    <p>When tags like &lt;font&gt;, and color attributes were added to the HTML 3.2 
        specification, it started a nightmare for web developers. Development of large 
        websites, where fonts and color information were added to every single  
        page, became a long and expensive process.</p>
    <p>When tags like &lt;font&gt;, and color attributes were added to the HTML 3.2 
        specification, it started a nightmare for web developers. Development of large 
        websites, where fonts and color information were added to every single  
        page, became a long and expensive process.</p>
    <p>CSS removed the style formatting from the HTML page!</p>
    <hr>
    <h2>CSS Saves a Lot of Work!</h2>
    <p>The style definitions are normally saved in external .css files.</p>
    <p>With an external stylesheet file, you can change the look of an entire website by changing just one file!</p>
    <br>
</div>



<script type="text/javascript">
    
    myTextArea = document.getElementById("code");
    var myCodeMirror = CodeMirror.fromTextArea(myTextArea, {
        lineNumbers: true,
        mode: "htmlmixed"
    });
    myCodeMirror.mode = "html";
    
</script>




