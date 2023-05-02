<?php
// $servername = "69.172.204.200";
// $username = "jasonhanna_me";
// $password = "HdyCJkU@#5Hv";
// $dbname = "jasonhanna_testDB";
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "jasonhanna_testDB";


$mysqli = mysqli_connect($servername, $username, $password, $dbname);


if ($mysqli -> connect_errno) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}


$sql = "SELECT c.cust_id, o.id, o.date, p.qty, i.pro_id, i.product, i.price, c.firstname "
        ."FROM inventory i, orders o, pro_qty p, customers c "
        ."WHERE "
            ." c.cust_id = o.cust_id AND "
            ."o.id = p.order_id AND "
            ."p.prod_id = i.pro_id "
            ."ORDER BY o.id;";

$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

if(mysqli_num_rows($result) > 0) {
    while ($row = $result->fetch_assoc()) {
        $order_id[] = $row['id'];
        $product[] = $row['product'];
        $qty[] = $row['qty'];
        $price[] = $row['price'];
        $date[] = $row['date'];
        //$order_date[] = [$row['id'] => $row['date']];
        if(!isset($user)) {
            $user = $row['firstname'];
        }
    }
    
    $order_date = array_combine($order_id, $date);
    $orderCount = array_count_values($order_id);
    $orderKey = array_keys($orderCount);
    $orderValues = array_values($orderCount);
    
    
}else {
    $sqlGetName = "SELECT firstname FROM customers WHERE cust_id = ".$cust_id.";";

    $getName = mysqli_query($mysqli, $sqlGetName) or die(mysqli_error($mysqli));

    $row = $getName->fetch_assoc();
    $user = $row['firstname'];
}

?>

<html>
<head>
<title>Order History</title>

    <link rel="stylesheet" href="style.css">
             
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
    <div class="topnav">
      <a  class="active" href="workerorder.php">Order</a>
      <a  href="inventory.php">Inventory</a>
      <a  href="static.php">Static</a>
      <a  href="index.php">logout</a>
    </div>
    <div>
        <h2>Below are the Orders</h2> 
    </div>
    <div>
        <?php 
            
            if(sizeof($product) < 1) {
                echo "<h3>Not have any order</h3>";
            } else {
                
                $count = 0;
                $i = 0;
                for($x = 0; $x < sizeof($orderCount); $x++) {
                        $total = 0;
                        echo "<h4>Order #".$orderKey[$x]."</h4>"
                            . "<h5>Date: ".$order_date[$orderKey[$x]]."</h5>";
                        echo "<table class='table table-striped'>"
                            . "<thead> <tr>"
                                . "<th scope='col'>Qty</th>"
                                . "<th scope='col'>Product</th>"
                                . "<th scope='col'>Price</th>"
                                . "<th scope='col'>Total</th>"
                        . "</tr><thead>"
                        . "<tbody>";
                        while($count < $orderValues[$x]) {
                            $total += $qty[$i] * $price[$i];
                        
                            echo "<tr>"
                                . "<th scope='row'>".$qty[$i]."</td>"
                                . "<td>".$product[$i]."</td>"
                                . "<td>$".number_format($price[$i], 2, '.', '')."</td>"
                                ."<td>$".number_format($qty[$i] * $price[$i], 2, '.', '')."</td>";
                            echo "</tr>";
                            $count++;
                            $i++;
                        }
                        echo "</table>"
                        . "<h4>Total: $".$total."</div>";
                        $count = 0;
         
                    }
                }
            
            
        ?>
    </div>
</body>
</html>