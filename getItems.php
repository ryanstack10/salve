<?php

require_once "db_config.php";

$conn = mysqli_connect(server, user, pass, name);

$sql = "SELECT * FROM item";

$result = $conn->query($sql);
$arr = [];
if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

		array_push($arr, [$row["id"], $row["name"], $row["description"], $row["price"], $row["stock"], $row["image"]]);

	}
} 

print json_encode($arr);

?>