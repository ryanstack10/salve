<?php session_start(); ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Salve</title>
        <script type="text/javascript" src="jsfunc.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

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
                                    <li><a href="stats.php">Stats</a></li>
                                    <?php } if ($_SESSION["in"]){?>
                                        <li><a href="history.php">History</a></li>
                                        <?php } ?>
                            </ul>
                        </div>
        </div>
        <div class="content">
            <script>
                $(document).ready(function() {
                    getProductDetails();
                });
            </script>
            <div id="imageDiv" class="left"></div>
            <div class="right">
                <div id="nameDiv"></div>
                <div id="descriptionDiv"></div>
                <div id="priceDiv"></div>
                <div id="stockNumDiv"></div>
                <div>Quantity:
                    <select id="quantitySelect">
                    </select>
                </div>
                <div>
                    <?php if($_SESSION["in"]) { ?>
                        <button onclick="addToCart($('#quantitySelect').val());">Add to cart</button>
                        <?php } else { ?>
                            <button onclick="document.location.href='login.php'">Login to add to cart</button>
                            <?php } ?>
                </div>
            </div>
        </div>
        <div class="footer">
        </div>
    </body>

    </html>