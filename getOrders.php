<?php
session_start();

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT order_id FROM history_customers WHERE customer_id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION["id"]);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$arr = [];

    foreach($stmt as $row) {

		array_push($arr, $row["order_id"]);

	}

print json_encode($arr);
?>