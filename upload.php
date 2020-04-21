<?php

$target_dir = "images/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "INSERT INTO item VALUES (0, :name, :description, :price, :stock, :imgName)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':name', $_POST["name"], PDO::PARAM_STR);
$stmt->bindParam(':description', $_POST["description"], PDO::PARAM_STR);
$stmt->bindParam(':price', $_POST["price"]);
$stmt->bindParam(':stock', $_POST["stock"]);
$stmt->bindParam(':imgName', basename($_FILES["fileToUpload"]["name"]), PDO::PARAM_STR);

$stmt->execute();

move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);

header("location: add.php");
?>