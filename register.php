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

<?php

require_once "db_config.php";

$conn = new PDO("mysql:host=". server. ";dbname=". name, user, pass);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$user = "";
$check = 0;

if(!empty(trim($_POST["user"]))){
	$sql = "SELECT count(id) FROM login WHERE username = :user";
	$stmt = $conn->prepare($sql);
	$stmt->bindParam(':user', $_POST["user"], PDO::PARAM_STR);
	$stmt->execute();
	$stmt->setFetchMode(PDO::FETCH_ASSOC);
		
	$numberOfRows = $stmt->fetchColumn();
	
				if ($numberOfRows > 0) {
                    echo "This username is already taken.";
                } else{
                    $user = trim($_POST["user"]);
                    $check = 1;
                }
}

if($check == 1){
	if(!empty(trim($_POST["pass"]))){
            $param_pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);

            $sql = "INSERT INTO login (username, password, type) VALUES (:user, :pass, 'CUSTOMER')";

    		$stmt = $conn->prepare($sql);
			$stmt->bindParam(':user', $user, PDO::PARAM_STR);
			$stmt->bindParam(':pass', $param_pass, PDO::PARAM_STR);
			$stmt->execute();

            $sql = "INSERT INTO customer(name, login_id) VALUES (:name, (SELECT id FROM login WHERE username = :user))";

            $stmt = $conn->prepare($sql);
			$stmt->bindParam(':name', $_POST["name"], PDO::PARAM_STR);
			$stmt->bindParam(':user', $user, PDO::PARAM_STR);
			$stmt->execute();

            
        	header("location: login.php");
        }
    }
unset($_POST);
?>

        <form action="register.php" method="POST" class="content">
            <div>
                <div>Name:</div>
                <input type="text" name="name" required>
            </div>
            <div>
                <div>Username:</div>
                <input type="text" name="user" required>
            </div>
            <div>
                <div>Password:</div>
                <input type="password" name="pass" required>
            </div>
            <div>
                <a href="login.php" style="font-size:12px;">Have an account? Login here</a>
            </div>
            <div>
                <input id="submitBtn" type="submit" value="Create Account">
            </div>
            <div>
                <p id="err"></p>
            </div>
        </form>
</body>

</html>