<?php
$base = $_POST['image'];
$name= $_POST['name'];
$imsrc = str_replace(' ','+',$base);
$binary = base64_decode($imsrc);
//header('Content-Type: bitmap; charset=utf-8');
$file = fopen($name, 'w');
fwrite($file, $binary);
if(fclose($file)){
 echo "Image Profile uploaded";
}else{
 echo "Error uploading image";
}
?>