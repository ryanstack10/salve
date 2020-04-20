<?php

require_once "db_config.php";

$conn = mysqli_connect(server, user, pass, name);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "INSERT INTO contact VALUES ('".$_POST["name"]. "', '". $_POST["email"]. "', '". $_POST["message"]. "')";

$result = $conn->query($sql);

header("location: contact.php");
?>