<?php
session_start();

require_once "db_config.php";

$conn = mysqli_connect(server, user, pass, name);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT order_id FROM history_customers WHERE customer_id = ". $_SESSION["id"];
$result = $conn->query($sql);

$arr = [];
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

		array_push($arr, $row["order_id"]);

	}
} 

print json_encode($arr);
?>