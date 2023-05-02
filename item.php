<?php
session_start();

if(!isset($_POST["qty"])) {
    if ((!filter_input(INPUT_POST, 'username'))
           || (!filter_input(INPUT_POST, 'password'))) {
            header("Location: index.php");
            exit;
    }
    

    
    //create and issue the query
    $targetname = filter_input(INPUT_POST, 'username');
    $targetpasswd = filter_input(INPUT_POST, 'password');
    $_SESSION['username'] = $targetname;
    $_SESSION['password'] = $targetpasswd;

}else {
    $targetname = $_SESSION['username'];
    $targetpasswd = $_SESSION['password'];
    $_SESSION['product'][] = $_POST['product'];
    $_SESSION['qty'][] = $_POST['qty'];
    $_SESSION['price'][] = $_POST['price'];
    $_SESSION['pro_id'][] = $_POST['pro_id'];
    
}

//connect to server and select database
// $servername = "69.172.204.200";
//     $username = "jasonhanna_me";
//     $password = "HdyCJkU@#5Hv";
//     $dbname = "jasonhanna_testDB";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jasonhanna_testDB";


    $mysqli = mysqli_connect($servername, $username, $password, $dbname);
    

$sql = "SELECT email, password, firstname, cust_id FROM customers WHERE email = '".$targetname.
        "' AND password = SHA1('".$targetpasswd."')";

$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

//get the number of rows in the result set; should be 1 if a match
if (mysqli_num_rows($result) == 1) {

	
	
        
        
        $row = $result->fetch_assoc();
        $name = $row["firstname"];
        $_SESSION['userID'] = $row['cust_id'];
        

} else {
	//redirect back to login form if not authorized
	header("Location: item.php");
	exit;
}

//Grocery items query
$sql = "SELECT product, price, pro_id FROM inventory";

$result2 = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
$products = array();
$price = array();
$pro_id = array();

if (mysqli_num_rows($result2) > 0) {
   
        while($row = $result2->fetch_assoc()) {
            $products[] = $row["product"];
            $price[] = $row["price"]; 
            $pro_id[] = $row["pro_id"];     
        }
}
?>
<html>
  
<head>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <title>Item Page</title>
</head>
<body>
    <div class="topnav">
      <a  class="active" href="item.php">Item</a>
      <a  href="cart.php">Cart</a>
      <a  href="history.php">Order History</a>
      <a  href="index.php">logout</a>
    </div>
    <div>
        <h2>Welcome <?php echo $name?>!</h2> 
        <h3>Please select items for purchase</h3>
    </div>
    <div>
        <?php 
            if(sizeof($products) < 1) {
                echo "No products available at this time";
            } else {
                for($i = 0; $i < sizeof($products); $i++) {
                    $value = $products[$i];
                    
                    echo "<div class='products'>"
                         ."<form method='post' action='custpage.php'>"
                         ."<label><Strong>".$value."</strong></label>"
                         ."<input hidden name='product' value='".$value."'><br>"
                         ."<label>price: $".$price[$i]."</label>"
                         ."<input hidden name='price' value='".$price[$i]."'><br>"
                         ."<input hidden name='pro_id' value='".$pro_id[$i]."'><br>"
                         ."<label for='qty'>Quantity:</label>"               
                         ."<select name='qty'>"
                            ."<options value=''>0</option>"
                            ."<option value='1'>1</option>"
                            ."<option value='2'>2</option>"
                            ."<option value='3'>3</option>"
                            ."<option value='4'>4</option>"
                            ."<option value='5'>5</option>"
                            ."<option value='6'>6</option>"
                            ."<option value='7'>7</option>"
                            ."<option value='8'>8</option>"
                            ."<option value='9'>9</option>"
                            ."<option value='10'>10</option>"
                            ."<option value='11'>11</option>"
                        ."</select><br>"
                        . "<input type='submit' value='add'/>"
                        ."</div><br>"
                        ."</form>";
                    
                }
            }
            
        ?>
    </div>
</body>
</html>

