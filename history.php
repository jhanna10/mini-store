<?php
session_start();
include 'dbcon.php';

if(filter_input (INPUT_COOKIE, 'auth') != session_id()) {
    header('Location: index.php');
    exit;
}

$cust_id = $_SESSION['userID'];


$sql = "SELECT c.cust_id, o.id, o.date, c.firstname 
        FROM inventory i, orders o, pro_qty p, customers c 
        WHERE c.cust_id = ".$cust_id." AND 
              c.cust_id = o.cust_id AND 
              o.id = p.order_id AND 
              p.prod_id = i.pro_id
        ORDER BY o.id DESC";

$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

if(mysqli_num_rows($result) > 0) {
   
    while ($row = $result->fetch_assoc()) {
        $order_id[$row['id']] = $row['date'];
        
        if(!isset($user)) {
            $user = strtoupper($row['firstname']);
        }
    }
    
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
 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="topnav">
      <a  href="custpage.php">Item</a>
      <a  href="cart.php">Cart</a>
      <a  class="active" href="history.php">Order History</a>
      <a  href="index.php">Logout</a>
    </div>
    <div>
        <h2>Welcome <?php echo $user?>!</h2> 
    </div>
    <div>
        <?php 
            
            foreach($order_id as $id => $date) {
                echo "<div class='p-5 rounded container'>";
                $total = 0;
                $getOrder = "SELECT o.date, p.qty, i.product, i.price 
                            FROM inventory i, orders o, pro_qty p 
                            WHERE o.id = ".$id." AND 
                                  o.id = p.order_id AND 
                                  p.prod_id = i.pro_id;";
                
                $result2 = mysqli_query($mysqli, $getOrder) or die(mysqli_error($mysqli));
                
                echo "<h4>Order #$id</h4>";
                echo "<h5>Date: $date</h5>";
                ?>
                <table class='table table-striped'>
                    <thead> 
                        <tr>
                            <th scope='col'>Qty</th>
                            <th scope='col'>Product</th>
                            <th scope='col'>Price</th>
                            <th scope='col'>Total</th>
                        </tr>
                    <thead>
                    <tbody>
                    <?php
                    while($line = $result2->fetch_assoc()) {
                        $row_total = $line['qty'] * $line['price'];
                        $total += $row_total;
                        
                        echo "<tr>"
                                . "<th scope='row'>".$line['qty']."</td>"
                                    . "<td>".$line['product']."</td>"
                                    . "<td>$".number_format($line['price'], 2, '.', '')."</td>"
                                    ."<td>$".number_format($row_total, 2, '.', '')."</td>"
                            ."</tr>";
                    }
                    echo "</table>"
                        . "<h4>Total: $".number_format($total, 2, '.', '')."</h4></div>";
            }
            
            
        ?>
    </div>
</body>
</html>
            