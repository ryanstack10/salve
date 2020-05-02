<?php
session_start();

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$sql = "SELECT name FROM item WHERE id IN (SELECT item_id FROM history_items GROUP BY item_id HAVING COUNT(item_id) = (SELECT MAX(numb) FROM (SELECT item_id, COUNT(item_id) as numb FROM history_items GROUP BY item_id) as maxnumb));";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$arr = [];

    foreach($stmt as $row) {

		array_push($arr, $row["name"]);

	}

print json_encode($arr);
?>