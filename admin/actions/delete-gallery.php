<?php
if($_SERVER["REQUEST_METHOD"] == "POST")
{
define('it', true); 
include("../include/db_connect.php"); 

$path = $_SERVER['DOCUMENT_ROOT']."/uploads_images/".$_POST["title"];

        if (file_exists($path))
        {  
          unlink($path);
          $delete = mysqli_query($link,"DELETE FROM uploads_images WHERE id = '{$_POST["id"]}'",$link); 
          echo "delete";   
        }
        else
        {
           echo "delete"; 
           $delete = mysqli_query($link,"DELETE FROM uploads_images WHERE id = '{$_POST["id"]}'",$link);  
        }

}
?>