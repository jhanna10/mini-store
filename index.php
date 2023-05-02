<!DOCTYPE html>
<html>
<head>
<title>Welcome</title>
<link rel="stylesheet" href="style.css">
</head>
<body class="home">
<form method="post" action="userlogin.php">
    <h1>Welcome to Jason's Mini-Store</h1>
    <p>Please login to access our store<p>
    
    
<fieldset> <legend><h3> Customer Login </h3></legend>
<p><strong>Username(Email):</strong><br/>
<input type="text" name="username"/></p>
<p><strong>Password:</strong><br/>
<input type="password" name="password"/></p>
<p><input type="submit" name="submit" value="Login"/></p>
<?php
if($_GET["cred"]) {
    ?>
    <p>Login credentials incorrect, please try again.<p>
<?php
}
?>
</fieldset>
    <p>Do not have an account? <a href="applyaccount.php">Create Account</a></p>
    <br><br><br><br>
    <!-- <a href="workerlogin.php">Employees</a> -->
</form>
</body>
</html>