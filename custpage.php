<?php
session_start();
include 'dbcon.php';

$name = $_SESSION['name'];

if(filter_input (INPUT_COOKIE, 'auth') != session_id()) {
    header('Location: index.php');
    exit;
}

if(!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

if(isset($_POST['pro_id'])) {
    $pid = $_POST['pro_id'];
    $qty = $_POST['qty'];

    if(isset($_SESSION['cart'][$pid])) {
        $_SESSION['cart'][$pid] += $qty; 
    } else {
        $_SESSION['cart'][$pid] = $qty;
    }
}

//Grocery items query
$sql = "SELECT product, price, pro_id FROM inventory";

$result2 = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

if (mysqli_num_rows($result2) > 0) {
   
        while($row = $result2->fetch_assoc()) {
            $products[$row['product']] = array('price' => $row['price'], 'pro_id' => $row['pro_id']);
            $price[] = $row["price"]; 
            $pro_id[] = $row["pro_id"];     
        }
}
?>
<html>
  
<head>
    <title>Item Page</title>    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" 
            integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    
</head>
<body>
    <div class="topnav">
      <a  class="active" href="custpage.php">Item</a>
      <a  href="cart.php">Cart</a>
      <a  href="history.php">Order History</a>
      <a  href="logout.php">Logout</a>
    </div>
    <div>
        <h2>Welcome <?php echo $name?>!</h2> 
        <h3>Please select items for purchase</h3>
    </div>
    <div>
        <?php 
            if(isset($products)) {
                foreach($products as $key => $arr) {
                    
                    echo "<div class='products container col'>"
                         ."<form method='post' action='custpage.php'>"
                         ."<label><Strong>".$key."</strong></label>"
                         ."<input hidden name='product' value='".$key."'><br>"
                         ."<label>price: $".number_format($arr['price'], 2, '.', '')."</label><br>"
                         ."<label for='qty'>Quantity: </label>"               
                         ."<select name='qty'>";
                         for($x = 0; $x < 16; $x++) {
                            echo "<option value='".$x."'>".$x."</option>";
                         }
                    echo "</select><br>"
                        . "<input type='submit' value='add'/>"
                        ."<input hidden name='price' value='".$arr['price']."'><br>"
                        ."<input hidden name='pro_id' value='".$arr['pro_id']."'><br>"
                        ."</div>"
                        ."</form>";
                    
                }
            } else {
                echo "No products available at this time";
            }
            
        ?>
    </div>
</body>
</html>

