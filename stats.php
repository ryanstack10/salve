<?php session_start(); ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Salve</title>
        <script type="text/javascript" src="jsfunc.js"></script>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        
        <script>
        	$(document).ready(function() {
                $.post("getNoShirt.php", function(nameData, status) {
                	var names = JSON.parse(nameData);
                	for( var i = 0; i < names.length; i++){
                		$("#noShirtDiv").append('<div style="margin-left: 2em;">' + names[i] + '</div>');
                	}
        		});
        		
        		$.post("getNoMoreThanTwo.php", function(nameData, status) {
                	var names = JSON.parse(nameData);
                	for( var i = 0; i < names.length; i++){
                		$("#noMoreThanTwoDiv").append('<div style="margin-left: 2em;">' + names[i] + '</div>');
                	}
        		});
        		
        		$.post("getMostCommonItems.php", function(nameData, status) {
                	var names = JSON.parse(nameData);
                	for( var i = 0; i < names.length; i++){
                		$("#mostCommonItemsDiv").append('<div style="margin-left: 2em;">' + names[i] + '</div>');
                	}
        		});
            });
        </script>

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
        	<div id="noShirtDiv">
        		<div>All customers who never order shirts</div>
        		<div>Customer name:</div>
        	</div>
        	<br>
            <div id="noMoreThanTwoDiv">
        		<div>All customers who never order more than two distinct items</div>
        		<div>Customer name:</div>
        	</div>
        	<br>
        	<div id="mostCommonItemsDiv">
        		<div>Most commonly purchased items</div>
        		<div>Item name:</div>
        	</div>
        </div>
        <div class="footer">
        </div>
    </body>

    </html>