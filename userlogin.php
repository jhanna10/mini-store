<?php

session_start();
include 'dbcon.php';
if((!filter_input(INPUT_POST, 'username'))
    || (!filter_input(INPUT_POST, 'password'))) {
        header("Location: index.php");
        exit;
}

$targetname = filter_input(INPUT_POST, 'username');
$targetpasswd = filter_input(INPUT_POST, 'password');

$sql = "SELECT email, password, firstname, cust_id FROM customers WHERE email = '".$targetname.
        "' AND password = SHA1('".$targetpasswd."')";

$result = mysqli_query($mysqli, $sql) or die(mysqli_error($mysqli));

//get the number of rows in the result set; should be 1 if a match
if (mysqli_num_rows($result) == 1) {

	//set authorization cookie using curent Session ID
	setcookie("auth", session_id(), time()+60*30, "/", "", 0);    
        
        $row = $result->fetch_assoc();
        $_SESSION['name'] = $row["firstname"];
        $_SESSION['userID'] = $row['cust_id'];
        header("Location: custpage.php");
        

} else {
	//redirect back to login form if not authorized
	header("Location: index.php?cred=false");
	exit;
}