
<?php
$display_block = "Please fill out all information"
                . "<br><br><a href=addProduct.php>Add Product</a>";
if(isset($_POST["submit"])) {
    
    if((!filter_input(INPUT_POST, "product")) || 
            (!filter_input(INPUT_POST, "price")) ||
            (!filter_input(INPUT_POST, "quantity")) ||
            (!filter_input(INPUT_POST, "category")) ) {
        ?>
        <html>
        <head>
        <title>Add</title>
        </head>
        <body style="background-color: lightblue">
        <h3><?php echo $display_block ?></h3>
        </form>
        </body>
        </html>
 <?php        
    }
  
    $servername = "69.172.204.200";
    $username = "jasonhanna_me";
    $password = "HdyCJkU@#5Hv";
    $dbname = "jasonhanna_testDB";


    $mysqli = mysqli_connect($servername, $username, $password, $dbname);
    
    
    $sql = "SELECT product FROM inventory WHERE product = '".$product."'";
    
    $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
    
    
    if(mysqli_num_rows($result) == 1) {
        $display_block ="Your product has been in the inventory.Please use another name.
                        <br><br>
                        <a href=addProduct.php>Back</a>";
                
        ?>
        <html>
            <head>
            <link rel="stylesheet" href="style.css">
            </head>
            <body>
            <h3><?php echo $display_block ?></h3>
            </form>
            </body>
        </html>
<?php
    }
    else {
        
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $category = $_POST["category"];
        $insert = "INSERT INTO inventory (product, price, quantity, category) "
                . "VALUES ('".$product."','".$price."','".$quantity."', '".$category
                ."');";
        
        if(mysqli_query($mysqli, $insert)) {
            $pathname = "/var/www/html/uploaddir/".$product;
            mkdir($pathname);
            chmod($pathname, 0733);
            $display_block ="Your product $product has been added.
                            <br><br>
                            <a href=addProduct.php>Back</a>";
            ?>
            <html>
                <head>
                    <link rel="stylesheet" href="style.css">
                </head>
                <body >
                <h3><?php echo $display_block ?></h3>
                </form>
                </body>
            </html>
            <?php
        }
        
    }
}
else {
?>   
   <html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
    <title>New Product</title>
    </head>
    <body>
    <div class="topnav">
      <a  href="order.php">Order</a>
      <a class="active" href="inventory.php">Inventory</a>
      <a  href="static.php">Static</a>
      <a  href="index.php">logout</a>
    </div>
        </br>
         <a class="button-29" type="button" href="addProduct.php">Add New Product</a>&nbsp;&nbsp;&nbsp;
    <form method="post" action="">
        <fieldset> <legend><h3> New Product </h3></legend>
        <p><strong>Product:</strong><br/>
        <input type="text" name="product"/></p>
        <p><strong>Price:</strong><br/>
        <input type="text" name="price"/></p>
        <p><strong>Quantity:</strong><br/>
        <input type="text" name="quantity"/></p>
        <p><strong>Category:</strong><br/>
         <select name="category">
		<option value='meat'>Meat</option>
		<option value='vege'>Vege</option>
		<option value='drink'>Drink</option>
                <option value='season'>season</option>
	</select>
        <p><input type="submit" name="submit" value="Add"/></p> 
        </fieldset>
        
    </form>
    </body>
</html>
<?php
}