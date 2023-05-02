
<?php
include 'dbcon.php';


if($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $firstname = filter_input(INPUT_POST, "firstname");
    $lastname = filter_input(INPUT_POST,"lastname");
    $email = strtolower(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $password = filter_input(INPUT_POST, "password");
    
    if(empty($firstname) || empty($lastname) || empty($email) || empty($password)) {
        $display_block = "Please fill out all information"
        . "<br><br><a href=applyaccount.php>Create Account</a>";

    } else {
        $sql = "SELECT email FROM customers WHERE email = ?"; 
        $stmt = mysqli_prepare($mysqli, $sql);
        mysqli_stmt_bind_param($stmt, 's', $email);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);

        if(mysqli_stmt_num_rows($stmt) == 1) {
            $display_block = "Your email address has already been used! Please use a different email address for a new account
            <br><br>
            <a href=applyaccount.php>Create Account</a>";

        } else {
            $insert = "INSERT INTO customers (firstname , lastname, email, password) " 
                ."VALUES (?, ?, ?, SHA1(?))";
            $stmt = mysqli_prepare($mysqli, $insert);
            mysqli_stmt_bind_param($stmt, 'ssss', $firstname, $lastname, $email, $password);
            mysqli_stmt_execute($stmt);

            if(mysqli_stmt_affected_rows($stmt) > 0) {
                $display_block = "Your account $email has been created. Thank you for joining us! 
                    <br><br> 
                    <a href=index.php>Go to Login</a>";
            }
        }
    }
            
}
?>   
<!DOCTYPE html>
<html>
    <head>
        <title>Create Account</title>
    </head>

    <body style="background-color: lightblue">
        <?php 
        if($display_block) {
            echo $display_block;
        }else {
        ?>
        <form method="post" action="">
            <fieldset> <legend><h3> New Account </h3></legend>
            <p><strong>First Name:</strong><br/>
            <input type="text" name="firstname" pattern="[A-Za-z]+" required/></p>
            <p><strong>Last Name:</strong><br/>
            <input type="text" name="lastname" pattern="[A-Za-z]+" required/></p>
            <p><strong>Email:</strong><br/>
            <input type="email" name="email" required/></p>
            <p><strong>Password:</strong><br/>
            <input type="password" name="password" required/></p>
            <p><input type="submit" name="submit" value="Create Account"/></p> 
            </fieldset>
            <a href="index.php">Back</a>
        </form>
        <?php
        }
        ?>
    </body>
</html>

