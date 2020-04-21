<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <script type="text/javascript" src="jsfunc.js"></script>
    <style>
        .content {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>

    <script>
        $(document).ready(function() {
            resetCart();
        });
    </script>

    <form action="login.php" method="POST" class="content">
        <div>
            <div>Username: </div>
            <input type="text" name="user" required>
        </div>
        <div>
            <div>Password: </div>
            <input type="password" name="pass" required>
        </div>
        <div>
            <a href="register.php" style="font-size:12px;">Dont have an account? Register here</a>
        </div>
        <div>
            <input id="submitBtn" type="submit" value="Submit">
        </div>
    </form>
<?php

session_start();

if(isset($_SESSION["in"]) && $_SESSION["in"] === true){
    header("location: index.php");
    exit;
}

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(!empty(trim($_POST["user"])) && !empty(trim($_POST["pass"]))){

$user = $_POST["user"];
$pass = $_POST["pass"];

$sql = "SELECT id, username, password, type FROM login WHERE username = :user";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':user', $_POST["user"], PDO::PARAM_STR);
$stmt->execute();
$stmt->setFetchMode(PDO::FETCH_ASSOC);
$stmt = $stmt->fetchAll()[0];

		if(password_verify($pass, $stmt["password"])){

			session_start();

			if($stmt["type"] == "WORKER"){
				$sql = "SELECT name FROM worker WHERE login_id = :id";
			}else{
				$sql = "SELECT name FROM customer WHERE login_id = :id";
			}

			$stmt2 = $conn->prepare($sql);
			$stmt2->bindParam(':id', $stmt["id"]);
			$stmt2->execute();
			$stmt2->setFetchMode(PDO::FETCH_ASSOC);
			$name = $stmt2->fetchColumn();

			$_SESSION["in"] = true;
			$_SESSION["id"] = $stmt["id"];
			$_SESSION["name"] = $name;
			$_SESSION["type"] = $stmt["type"];

			header("location: index.php");
		} else {
				echo "Wrong username or password";
		}
	
}
?>

</body>

</html>