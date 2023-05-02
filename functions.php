<?php 
function addOrder($mysqli) {
    $cust_id = $_SESSION['userID'];
    $insert = "INSERT INTO orders (cust_id, date) VALUES (".$cust_id.", CURRENT_DATE());";
   
    //get the number of rows in the result set; should be 1 if a match
    if (mysqli_query($mysqli, $insert)) {
        $sql = "SELECT id FROM orders ORDER BY id DESC LIMIT 1";
        $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
        $row = $result->fetch_assoc();
        $order_id = $row["id"];
        
        foreach($_SESSION['cart'] as $key => $val) {
            $insert2 = "INSERT INTO pro_qty (prod_id, order_id, qty) VALUES (".$key.", "
                    .$order_id.", ".$val.");";
            $mysqli->query($insert2);
        }
        $_SESSION['cart'] = array();
        ?>
        <div>
            <h2>Order Successful</h2> 
            <h3><a href='history.php'>Order History</a></h3>
        </div>
        <?php
    } else {
        ?> 
        <div>
            <h2>Order Unsuccessful</h2> 
            <h3><a href='history.php'>Order History</a></h3>
        </div>
        <?php
    }
}

function displayOrder($mysqli) {
    $total;
    if(!$_SESSION['cart']) {
        ?>
        <h3>Cart Empty</h3>
        <?php
    } else {
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
            foreach($_SESSION['cart'] as $key => $val) {
                $sql = "SELECT * FROM inventory WHERE pro_id = '$key'";
                $result = mysqli_query($mysqli, $sql) or die("Bad SQL: $sql");
                $row = mysqli_fetch_assoc($result);
                $sub = $val * $row['price'];
                $total += $sub;
                echo "<tr>"
                    . "<th scope='row'>".$val."</td>"
                    . "<td>".$row['product']."</td>"
                    . "<td>$".number_format($row['price'], 2, '.', '')."</td>"
                    ."<td>$".number_format($sub, 2, '.', '')."</td>";
                echo "</tr>";
            }
        echo "</table></div>";
        echo "<div>"
                ."<h5>Total: $".number_format($total, 2, '.', '')."</h5>";    
        ?>
            <form method='post'>
                <input type='submit' value='Confirm Order' name='added'>
            </form>
        </div>
        <?php
    }

   
}