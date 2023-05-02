<?php 
    // $servername = "localhost";
    // $username = "root";
    // $password = "letmein";
    // $dbname = "jasonhanna_testDB";
    
    $servername = "69.172.204.200";
    $username = "jasonhanna_me";
    $password = "HdyCJkU@#5Hv";
    $dbname = "jasonhanna_testDB";

    $mysqli = mysqli_connect($servername, $username, $password, $dbname);

    if ($mysqli -> connect_errno) {
        echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
        exit();
    }
    
?>