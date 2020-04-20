<?php session_start(); ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Salve</title>
        <script type="text/javascript" src="jsfunc.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

        <style>
            .content {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
            }
        </style>

    </head>

    <body>
        <div class="header">
            <span id="username"><?php echo $_SESSION["name"];?></span>
            <?php if($_SESSION["in"]){?>
                <a id="logoutBtn" href="logout.php">logout</a>
                <?php } else { ?>
                    <a id="logoutBtn" href="login.php">login/register</a>
                    <?php } ?>
                        <p>Salve</p>

                        <div id="navBar">
                            <ul>
                                <li><a href="index.php">Shop</a></li>
                                <li><a href="contact.php">Contact Us</a></li>
                                <li><a href="about.php">About Us</a></li>
                                <li><a href="cart.php">Cart</a></li>
                                <?php if($_SESSION["type"] == "WORKER" && $_SESSION["in"]) {?>
                                    <li><a href="add.php">Add Item</a></li>
                                    <?php } if ($_SESSION["in"]){?>
                                        <li><a href="history.php">Order History</a></li>
                                        <?php } ?>
                            </ul>
                        </div>
        </div>
        <div class="content">
            <form action="uploadContact.php" method="post">
                <div>
                    <div>Name:</div>
                    <input type="text" name="name" id="name">
                </div>
                <div>
                    <div>Email:</div>
                    <input type="text" name="email" id="email">
                </div>
                <div>
                    <div>Message:</div>
                    <input type="text" name="message" id="message">
                </div>
                <div>
                    <input type="submit" value="Contact" name="submit">
                </div>
            </form>
        </div>
        <div class="footer">
        </div>
    </body>

    </html>