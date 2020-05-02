<?php
session_start();

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT name FROM customer WHERE login_id IN (SELECT DISTINCT customer_id FROM history_customers H WHERE order_id NOT IN (SELECT I.order_id FROM history_items I GROUP BY order_id HAVING COUNT(item_id) > 2));";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$arr = [];

    foreach($stmt as $row) {

		array_push($arr, $row["name"]);

	}

print json_encode($arr);
?>
