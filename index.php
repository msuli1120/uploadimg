<?php

  $server = 'mysql:host=localhost:8889;dbname=photos';
  $user = 'root';
  $pass = 'root';
  $db = new PDO($server, $user, $pass);

  if(isset($_POST['upload'])){

    $imgFile = $_FILES['image']['name'];
    $tempDir = $_FILES['image']['tmp_name'];
    $imgSize = $_FILES['image']['size'];

    $upload_dir = 'images/';

    $imgExt = strtolower(pathinfo($imgFile,PATHINFO_EXTENSION));
    $valid_exts = array ('jpeg', 'jpg', 'png', 'gif');

    $usrpic = rand(1000,1000000).".".$imgExt;  //rename image

    if(in_array($imgExt, $valid_exts)){
      if($imgSize<10000000){
        move_uploaded_file($tempDir, $upload_dir.$usrpic);
      } else {
        $msg = "file is too large";
      }
    } else {
      $msg = "only JPG, JPEG, PNG & GIF";
    }

    if(!isset($msg)){
      $executed = $db->prepare("INSERT INTO images (image) VALUES (:image);");
      $executed->bindParam(':image', $usrpic);
      $executed->execute();
    }





  }

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Upload Images</title>
  </head>
  <body>
    <form method="post" action="index.php" enctype="multipart/form-data">
      <input type="file" name="image">
      <input type="submit" name="upload" value="Upload Image">
    </form>
  </body>
</html>
