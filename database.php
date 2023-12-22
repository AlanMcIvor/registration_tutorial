<?php

// this scrip allows us to connect to our database
$host = "localhost";
$dbname = "login_db";
$username = "login_admin";
$password = "qYV4frIGZg4MR698";


// create a new mysqli objectThe new mysqli(...) part creates a new instance of the mysqli class, which represents a connection to a MySQL database. The parameters passed to the mysqli constructor are used to configure and establish the connection to the MySQL server.these variables must be in this order, host, username, password, dbname
// After this line of code, the variable $mysqli will hold the instance of the mysqli class, and you can use it to perform database operations like executing queries, fetching results, and managing the connection to the MySQL serve
$mysqli = new mysqli(
    $host,
    $username,
    $password,
    $dbname
);

if ($mysqli->connect_errno){
    die("connection error: " . $mysqli->connect_error);
}

return $mysqli;

// $mysqli->connect_errno: This is a property of the mysqli class that holds the error number (if any) resulting from a failed connection attempt. If the connection is successful, connect_errno will be zero.

// The if statement checks if $mysqli->connect_errno is not zero. In other words, it checks if there was an error during the connection attempt.

// If there was an error ($mysqli->connect_errno is not zero), the script enters the if block.

// die("connection error: " . $mysqli->connect_error);: The die function is used to terminate the script and display an error message. In this case, the error message includes "connection error:" followed by the specific error message obtained from $mysqli->connect_error.