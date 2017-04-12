<?php
header('Access-Control-Allow-Origin: *');
$target_path = "forums/";
$uploadfile = $_POST['fileName'];
$uploadfilename = $_FILES['file']['tmp_name'];
if(move_uploaded_file($uploadfilename, $target_path. '' .$uploadfile)) {
   echo "Upload and move success";
} else{
echo $target_path;
   echo "There was an error uploading the file, please try again!";
}
?>