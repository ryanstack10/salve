<?php

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

$sql = "SELECT * FROM item";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);

$arr = [];


    foreach($stmt as $row) {

		array_push($arr, [$row["id"], $row["name"], $row["description"], $row["price"], $row["stock"], $row["image"]]);

	}


print json_encode($arr);

?>