<?php

include_once('/var/www/html/cloud/models/db/dbLib.php');
include_once('/var/www/html/cloud/models/db/session.php');


session_start();
$session_id='1'; // User session id
$path = "uploads/";

$valid_formats = array("jpg", "png", "gif", "bmp","jpeg", "JPG", "", "PNG", "svg");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST")
{
$name = $_FILES['imageUp']['name'];
$size = $_FILES['imageUp']['size'];
if(strlen($name))
{
list($txt, $ext) = explode(".", $name);
//if(in_array($ext,$valid_formats))
if( !exif_imagetype($_FILES['imageUp']))
{
if($size<(10240*10240)) // Image size max 1 MB
{
$actual_image_name = time().$session_id.".".$ext;
$tmp = $_FILES['imageUp']['tmp_name'];
if(move_uploaded_file($tmp, $path.$actual_image_name))
{
//mysql_query("UPDATE users SET profile_image='$actual_image_name' WHERE uid='$session_id'");
echo "http://reslift.com/cloud/api/add/uploads/".$actual_image_name;
}
else
echo "failed";
}
else
echo "Image file size max 1 MB"; 
}
else
echo "Invalid file format.."; 
}
else
echo "Please select image..!";
exit;
}

?>