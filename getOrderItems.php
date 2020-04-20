<?php
session_start();

require_once "db_config.php";

$conn = mysqli_connect(server, user, pass, name);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT item_id, quantity FROM history_items WHERE order_id = ". $_POST["order_id"];
$items = $conn->query($sql);

$arr = [];
if ($items->num_rows > 0) {

    while($row = $items->fetch_assoc()) {
		$sql = "SELECT name FROM item WHERE id = ". $row["item_id"];
		$name = $conn->query($sql)->fetch_assoc();
		
		array_push($arr, [$name["name"], $row["quantity"]]);

	}
} 

print json_encode($arr);
?>