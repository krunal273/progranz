<?php

$filename = generateRandomString(10) . ".html";
$path = "../try/" . $filename;

$myfile = fopen($path . $filename, "w") or die("Unable to open file!");
$txt = "Mickey Mouse\n";
fwrite($myfile, $txt);
fclose($myfile);
?>