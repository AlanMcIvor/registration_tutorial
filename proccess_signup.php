<?php

// validate name
if(empty($_POST["name"])){
    // end script if name value is empty
    die("name is required");
}

// validate email
// : This function is used to filter a variable with a specified filter. In this case, the filter being used is FILTER_VALIDATE_EMAIL, which checks if the provided variable is a valid email address according to the email address format standards.
if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
    // if email field is not a valid email end script
    die("valid email is required");
}
// validate password
// if password less than 8 characters end script
if(strlen($_POST["password"]) < 8){
    die("password must be at least 8 characters long");
}

// check password contains at least one letter using a regular expression
if (!preg_match("/[a-z]/i", $_POST["password"])){
    die("password must contain at least one letter");
}

// check password contains at least one number using a regular expression
if (!preg_match("/[0-9]/i", $_POST["password"])){
    die("password must contain at least one letter");
}

// validate password confirmation
if ($_POST["password"] !== $_POST["confirm_password"]){
    die("passwords must match");
}

// hash the password so it does not save as plain text
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// connect to the database
$mysqli = require __DIR__ . "/database.php";

// create a new prepared statement for our data base using sql
// the id feild in the database is an auto increment and as such will auto increment without us adding anything

// the question marks are placeholders

// $mysqli: This is an instance of the mysqli class, representing a connection to a MySQL database.

// $mysqli->stmt_init(): This method is used to initialize a new statement object. A statement object is used for preparing and executing SQL queries in a way that allows for parameter binding, which can enhance security and performance.

$sql = "INSERT INTO user (name, email, password_hash)
VALUES (?,?,?)";

    $stmt = $mysqli->stmt_init();
   
    if (!$stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    };

    // bind out values to our placeholders, the "s" represents a string
    // and we then select our valuables to pass in
    $stmt->bind_param("sss", 
                    $_POST["name"],
                    $_POST["email"],
                    $password_hash);

    // execute the statmemt and check for duplicate database entries
    if($stmt->execute()){

        // redirect upon successfull sign up
        header("Location: signup_success.html");
        exit;
        
    }else {

        if ($mysqli->errno === 1062){
            die("email already taken");
        }else {
        die($mysqli->error . " " . $mysqli->errono);
        }
    };



// print_r($_POST);
// var_dump($password_hash);

?>
