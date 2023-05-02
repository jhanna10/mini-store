<?php
session_start();
include 'dbcon.php';
include 'functions.php';

if(filter_input (INPUT_COOKIE, 'auth') != session_id()) {
    header('Location: index.php');
    exit;
}

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}
 
?>
<html>
    <head>
        <title>Customer Page</title>    
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="topnav">
        <a  href="custpage.php">Item</a>
        <a  class="active" href="cart.php">Cart</a>
        <a  href="history.php">Order History</a>
        <a  href="index.php">Logout</a>
        </div>
    <?php
    if(isset($_POST['added'])) {
        addOrder($mysqli);
    }else {
        displayOrder($mysqli);
    }
    ?>
    </body>
</html>



