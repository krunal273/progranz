<?php include_once '../includes/codecompiler.php'; ?>

<div>
    <p>Colors in CSS are most often specified by:</p>
    <ul>
        <li>a valid color name - like "red"</li>
        <li>an RGB value - like "rgb(255, 0, 0)"</li>
        <li>a HEX value - like "#ff0000"</li>
    </ul>
</div>
<hr>

<div>
    <h2>Color Names</h2>
    <p>Colors set by using color names:</p>
    <div>
        <h3>Example</h3>
        <div>
            <div>
                <table class="table table-striped table-responsive">
                    <tbody><tr>
                            <th style="width:50%">Color</th>
                            <th>Name</th>
                        </tr>
                        <tr><td style="background-color:red">&nbsp;</td><td>Red</td></tr>
                        <tr><td style="background-color:green">&nbsp;</td><td>Green</td></tr>
                        <tr><td style="background-color:blue">&nbsp;</td><td>Blue</td></tr>
                        <tr><td style="background-color:orange">&nbsp;</td><td>Orange</td></tr>
                        <tr><td style="background-color:yellow">&nbsp;</td><td>Yellow</td></tr>
                        <tr><td style="background-color:cyan">&nbsp;</td><td>Cyan</td></tr>
                        <tr><td style="background-color:black">&nbsp;</td><td>Black</td></tr>
                    </tbody></table>
            </div>  
        </div>
    </div>
</div>
<hr>

<div>
    <h2>RGB (Red, Green, Blue)</h2>
    <p>RGB color values can be specified using this formula: rgb(red, green, blue).</p>
    <p>Each parameter (red, green,  
        blue) defines the intensity of the color between 0 and 255.</p>
    <p>For example, <code class="w3-codespan">rgb(255,0,0)</code> is displayed as red, 
        because red is set to its highest value (255) and the others are 
        set to 0. Experiment by mixing the RGB values below:</p>
    <textarea id="code">
<!DOCTYPE html>
<html>
<body>

<h2>RGB Color Examples</h2>

<h2 style="background-color:rgb(255, 0, 0)">
Background-color set by using rgb(255, 0, 0)
</h2>

<h2 style="background-color:rgb(0, 255, 0)">
Background-color set by using rgb(0, 255, 0)
</h2>

<h2 style="background-color:rgb(0, 0, 255)">
Background-color set by using rgb(0, 0, 255)
</h2>

<h2 style="background-color:rgb(255, 165, 0)">
Background-color set by using rgb(255, 165, 0)
</h2>

<h2 style="background-color:rgb(255, 255, 0)">
Background-color set by using rgb(255, 255, 0)
</h2>

<h2 style="background-color:rgb(0, 255, 255)">
Background-color set by using rgb(0, 255, 255)
</h2>

</body>
</html></textarea>
    <button class="btn btn-success">code compile</button>
</div>
<hr>
<div>
    <h2>Hexadecimal Colors</h2>
    <p>RGB values can also be specified using <strong>hexadecimal</strong> color values in 
        the form: #<em>RRGGBB</em>, where RR (red), GG (green) and BB (blue) are hexadecimal 
        values between 00 and FF (same as decimal 0-255).</p>
    <p>For example, <code class="w3-codespan">#FF0000</code> is displayed as red, because red is set to its highest value (FF) and the others are set to 
        the lowest value (00). <strong>Note:</strong> HEX values are case-insensitive: "#ff0000" is the same as "FF0000".</p>

    <textarea id="code1">
<!DOCTYPE html>
<html>
<body>

<h2>HEX Color Examples</h2>

<h2 style="background-color:#FF0000">
Background-color set by using #FF0000
</h2>

<h2 style="background-color:#00FF00">
Background-color set by using #00FF00
</h2>

<h2 style="background-color:#0000FF">
Background-color set by using #0000FF
</h2>

<h2 style="background-color:#FFA500">
Background-color set by using #FFA500
</h2>

<h2 style="background-color:#FFFF00">
Background-color set by using #FFFF00
</h2>

<h2 style="background-color:#00FFFF">
Background-color set by using #00FFFF
</h2>

</body>
</html></textarea>
    
    <button class="btn btn-success" src="../../public/try.php">code compile</button>
</div>
<div>
    <blockquote><p><b>Advanced colors:</b> In our <a href="css3_colors.asp">CSS3 Colors Tutorial</a>, you will learn about HSL and RGBa colors.</p></blockquote>
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
</script>

