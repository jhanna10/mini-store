<?php
    if (!filter_input(INPUT_POST, 'choice')) {
?>
    <html>
    <head>
        <link rel="stylesheet" href="style.css">
    </head>
        <body>
        <div class="topnav">
      <a  href="workerorder.php">Order</a>
      <a  href="inventory.php">Inventory</a>
      <a class="active" href="static.php">Static</a>
      <a  href="index.php">logout</a>
    </div>
            </br>
        <h4>Graph Information for our Inventory:</h4>
	<form action="" method="POST">		
	    <select name="choice">
		<option value='Quantity'>Quantity</option>
		<option value='Price'>Price</option>
		
	    </select>
	    <br /><br />
	    <input type="submit" value="Submit">
	</form>
    </body></html>
<?php    
    } elseif(filter_input(INPUT_POST, 'choice')) {
  
    /* Open connection to "testDB" MySQL database. */
    // $servername = "69.172.204.200";
    // $username = "jasonhanna_me";
    // $password = "HdyCJkU@#5Hv";
    // $dbname = "jasonhanna_testDB";
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "jasonhanna_testDB";


    $mysqli = mysqli_connect($servername, $username, $password, $dbname);
    
 
    /* Check the connection. */
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
     $choice = filter_input(INPUT_POST, 'choice');
     $country = "product";
     $mydata = "";
     $mylabel ="";
    /* Fetch result set from Sales table */
    $data=mysqli_query($mysqli,"SELECT product, $choice FROM inventory;");
  
  
?>  
  
<html>
<head>
  <script src="zingchart.min.js"></script>
 
  <style>
    html,
    body,
    #NAFTAChart {
      height: 90%;
      width: 90%;
    }
  </style>
</head>

<body>
  <div id='NAFTAChart'></div>
  <script>
    
    <?php 
        while($info=mysqli_fetch_array($data)){
            $mydata .=  $info[$choice].','; 
            $mylabel .= "\"$info[$country]\"".','; 
        }
    ?>
    
    var myConfig = {
        "graphset": [{
        "type": "bar",
        "title": {
          "text": " <?php echo $_POST['choice'].
                  (($_POST['choice'] == 'quantity')? " ":" "); ?>"
        },
        "scale-x": {
          "labels": [<?php echo $mylabel; ?>]
        },
        "series": [
        {
            "values":[<?php echo $mydata; ?>]
        }]
    }]
    };

    zingchart.render({
      id: 'NAFTAChart',
      data: myConfig,
      height: "100%",
      width: "100%"
    });
  </script>
  <a href="static.php">Back
</body>

</html>
    <?php } ?>
