<?php

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "INSERT INTO contact VALUES (:name, :email, :message)";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':name', $_POST["name"], PDO::PARAM_STR);
$stmt->bindParam(':email', $_POST["email"], PDO::PARAM_STR);
$stmt->bindParam(':message', $_POST["message"], PDO::PARAM_STR);

$stmt->execute();

header("location: contact.php");
?>