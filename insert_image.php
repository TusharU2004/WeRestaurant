
<?php

//insert.php

if(isset($_POST["image"]))
{
    require_once('inc/common.php');
 //include('database_connection.php');
$upload='img/';
 $data = $_POST["image"];
 
 $image_array_1 = explode(";", $data);

 $image_array_2 = explode(",", $image_array_1[1]);

 $data = base64_decode($image_array_2[1]);

 $imageName =$upload. time() . '.png';

 file_put_contents($imageName, $data);

$image_file = addslashes(file_get_contents($imageName));

$updQry = "`logo`='".$image_file."',";
 //$query = "INSERT INTO tbl_images(images) VALUES ('".$image_file."')";
 //mysqli_query($conn, "UPDATE `settings` SET ".substr($updQry, 0, -1));

 //$statement = $connect->prepare($mysqli_query);

 //if($statement->execute())
 //{
  echo 'Image save into database';
  
 //}

}

?>