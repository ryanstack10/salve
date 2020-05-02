<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$cart = json_decode($_POST['cart'], true);

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "INSERT INTO history_customers VALUES(:id, 0, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $_SESSION["id"]);
$stmt->execute();

$sql = "SELECT order_id FROM history_customers ORDER BY order_id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$order = $stmt->fetchColumn();

foreach($cart as $item){
	$sql = "SELECT stock FROM item WHERE id = :id";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':id', $item[0]);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
	$stock = $stmt->fetchColumn();

	$sql = "UPDATE item SET stock =(:stock - :quantity) WHERE id = :id";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':stock', $stock);
	$stmt->bindParam(':quantity', $item[1]);
	$stmt->bindParam(':id', $item[0]);
	$stmt->execute();
	
	$sql = "INSERT INTO history_items values(:id, :order, :quantity)";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':order', $order);
	$stmt->bindParam(':id', $item[0]);
	$stmt->bindParam(':quantity', $item[1]);
	$stmt->execute();
}
?>