<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$cart = json_decode($_POST['cart'], true);

require_once "db_config.php";

$conn = mysqli_connect(server, user, pass, name);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "INSERT INTO history_customers VALUES(". $_SESSION['id']. ", 0)";
$result = $conn->query($sql);
print_r("0". $conn->error);

$sql = "SELECT order_id FROM history_customers ORDER BY order_id DESC LIMIT 1";
$order = $conn->query($sql)->fetch_assoc();

$_SESSION["order_id"] = $order["order_id"];

foreach($cart as $item){
	$sql = "SELECT id, stock FROM item WHERE id = ". $item[0];
	$stock = $conn->query($sql)->fetch_assoc();
	print_r("1". $conn->error);

	$sql = "UPDATE item SET stock =(". $stock["stock"]. " - ". $item[1]. ") WHERE id = ". $item[0];
	$result = $conn->query($sql);
	print_r("2". $conn->error);
	
	$sql = "INSERT INTO history_items values(". $stock["id"]. ", ". $order["order_id"]. ", ". $item[1]. ")";
	$result = $conn->query($sql);
	print_r("3". $conn->error);
}
?>