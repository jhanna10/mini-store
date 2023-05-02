<?php
    $servername = "69.172.204.200";
    $username = "jasonhanna_me";
    $password = "HdyCJkU@#5Hv";
    $dbname = "jasonhanna_testDB";


    $mysqli = mysqli_connect($servername, $username, $password, $dbname);
    
    $sql = "SELECT * from inventory;";
    $result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));
               
    if (mysqli_num_rows($result)< 1){
        header ("Location: inventory.php");
    }
    else {
        echo "<h2> Category List: </h2>";
        echo "<pre>";
        printf("Product\tPricet\t\tQuantity\tCategory\n");
        printf("%'-85s\n","");
        while ($row = mysqli_fetch_array($result)){
            printf("%s\t%-24s%s\t%s\n", $row['Product'],$row['Price'],
                   $row['Quantity'],$row['Category']);
        
                     } //while     
        echo "</pre>";
     
    } //else   
?>
