<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
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

$conn = mysqli_connect(server, user, pass, name);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

if(!empty(trim($_POST["user"])) && !empty(trim($_POST["pass"]))){
$user = $_POST["user"];
$pass = $_POST["pass"];

$sql = "SELECT id, username, password, type FROM login WHERE username = '". $user. "'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    while($row = $result->fetch_assoc()) {

				if(password_verify($pass, $row["password"])){

				session_start();

				if($row["type"] == "WORKER"){
					$sql = "SELECT name FROM worker WHERE login_id = ". $row["id"];
				}else{
					$sql = "SELECT name FROM customer WHERE login_id = ". $row["id"];
				}

				$name = $conn->query($sql)->fetch_assoc();

				$_SESSION["in"] = true;
				$_SESSION["id"] = $row["id"];
				$_SESSION["name"] = $name["name"];
				$_SESSION["type"] = $row["type"];

				header("location: index.php");
				} else {
					echo "Wrong username or password";
				}
			}
		} 

}
?>

</body>

</html>