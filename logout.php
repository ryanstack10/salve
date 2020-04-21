<?php

session_start();

$_SESSION = array();

session_destroy();

?>

    <!DOCTYPE html>
    <html>

    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script type="text/javascript" src="jsfunc.js"></script>
    </head>

    <body>

        <p>Thank you for visiting</p>
        <p>You will be redirected in <span id="countDown">5</span> seconds</p>
        <script>

            var count = 5;
            setInterval(function() {
                count--;
                document.getElementById('countDown').innerHTML = count;
                if (count == 0) {
                	resetCart();
                    window.location = 'index.php';
                }
            }, 1000);
        </script>
    </body>

    </html>