<?php
session_start();

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT item_id, quantity FROM history_items WHERE order_id = :order_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':order_id', $_POST["order_id"]);

$stmt->execute();

$arr = [];

	$stmt->setFetchMode(PDO::FETCH_ASSOC);

    foreach($stmt as $row) {
		$sql = "SELECT name FROM item WHERE id = :id";
		
		$stmt2 = $conn->prepare($sql);
		$stmt2->bindParam(':id', $row["item_id"]);
		$stmt2->execute();
		$stmt2->setFetchMode(PDO::FETCH_ASSOC);
		
		$name = $stmt2->fetchColumn();
		
		array_push($arr, [$name, $row["quantity"]]);

	}

print json_encode($arr);
?>