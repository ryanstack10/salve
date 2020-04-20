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

$conn = mysqli_connect(server, user, pass, name);

if($conn === false){
    die("ERROR: Could not connect. " . mysqli_connect_error());
}

$user = "";
$check = 0;

if(!empty(trim($_POST["user"]))){
	$sql = "SELECT id FROM login WHERE username = '". $_POST["user"]. "'";

		$result = $conn->query($sql);
				if ($result->num_rows > 0) {
                    echo "This username is already taken.";
                } else{
                    $user = trim($_POST["user"]);
                    $check = 1;
                }
}

if($check == 1){
if(!empty(trim($_POST["pass"]))){
            $param_user = $user;
            $param_pass = password_hash($_POST["pass"], PASSWORD_DEFAULT);

            $sql = "INSERT INTO login (username, password, type) VALUES ('". $param_user. "', '". $param_pass. "', 'CUSTOMER')";

            $result = $conn->query($sql);

            $sql = "INSERT INTO customer(name, login_id) VALUES ('". $_POST["name"]. "', (SELECT id FROM login WHERE username = '". $param_user. "'))";

            $result = $conn->query($sql);

            if($result){
                header("location: login.php");
            }

        }
    }
$conn->close();
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