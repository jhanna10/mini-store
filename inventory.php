<?php
session_start();
?>
<html>
    
<head>
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<script>
    function myFunction() {
  document.getElementById("myDropdown").classList.toggle("show");
    }


window.onclick = function(e) {
  if (!e.target.matches('.dropbtn')) {
  var myDropdown = document.getElementById("myDropdown");
    if (myDropdown.classList.contains('show')) {
      myDropdown.classList.remove('show');
    }
  }
}
</script>
<body>
    <div class="topnav">
      <a  href="workerorder.php">Order</a>
      <a  class="active" href="inventory.php">Inventory</a>
      <a  href="static.php">Static</a>
      <a  href="index.php">logout</a>
    </div>
    
        </br>
         <a  class="button-29" type="button" href="addProduct.php">Add New Product</a>&nbsp;&nbsp;&nbsp; 
         </br> </br>
         <form method="post" action="">
        <strong>Select a Category:</strong>
         <select name="choice">
                <option value='all'>All</option>
		<option value='meat'>Meat</option>
		<option value='vege'>Vege</option>
		<option value='drink'>Drink</option>
                <option value='season'>season</option>
	</select>
        <input type="submit" name="submit" value="Submit"/>
        </fieldset>
        
    </form>
	    
	    
	
         
         <?php
             
             $choice = filter_input(INPUT_POST, 'choice');
             
    //          $servername = "69.172.204.200";
    // $username = "jasonhanna_me";
    // $password = "HdyCJkU@#5Hv";
    // $dbname = "jasonhanna_testDB";
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "jasonhanna_testDB";


    $mysqli = mysqli_connect($servername, $username, $password, $dbname);
    
             
             if($choice === 'all'){
                 $sql = "SELECT * FROM inventory";
             } elseif ($choice === 'meat') {
                 $sql = "SELECT * from inventory WHERE category = 'meat'";
             } elseif ($choice === 'vege') {
                 $sql = "SELECT * from inventory WHERE category = 'vege'";
             } elseif ($choice === 'drink') {
                 $sql = "SELECT * from inventory WHERE category = 'drink'";
             } else {
                 $sql = "SELECT * from inventory WHERE category = 'season'";
             }
             
             
             $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
    
            if (mysqli_num_rows($result)< 1){
                header ("Location: inventory.php");
            }
            else {

                echo "<h2> Whole Inventory: </h2>"; //$choice change when different choice
                echo "<pre>";
                printf("Product ID\tProduct\t\t Price\t\t\tQuantity\t\t\tCategory\n");
                printf("%'-120s\n","");
                while ($row = mysqli_fetch_array($result)){
                    printf("%s\t\t%s\t\t  %s\t\t\t  %s\t\t\t\t  %s\n",$row['pro_id'], $row['product'],$row['price'],
                           $row['quantity'],$row['category']);

                             }   
                echo "</pre>";
            }
            
            ?>
             
        </form>
</body>
</html>



