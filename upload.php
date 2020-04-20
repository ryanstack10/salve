<?php

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

require_once "db_config.php";

$conn = mysqli_connect(server, user, pass, name);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "INSERT INTO item VALUES (0, '". $_POST["name"]. "', '". $_POST["description"]. "', ". $_POST["price"]. ", ". $_POST["stock"]. ", '". basename($_FILES["fileToUpload"]["name"]). "')";

$result = $conn->query($sql);

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

header("location: add.php");
?>