<?php

$is_invalid = false;

// check if the form has been submitted
// when the form is submitted the method will be post
// when it is subbmitted check the email and password match what is held in 
// database

   if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // if ($_SERVER["REQUEST_METHOD"] === "POST"): This line checks if the HTTP request method is POST. It is a common practice to use POST for form submissions, as opposed to GET, which is used for fetching data. The $_SERVER["REQUEST_METHOD"] variable contains the request method used to access the page.

    $mysqli = require __DIR__ . "/database.php"; 
    // $mysqli = require __DIR__ . "/database.php";: This line includes the database.php file and assigns its return value to the $mysqli variable. The __DIR__ constant represents the directory of the current script, and it's used here to create an absolute path.
    
    $email = $mysqli->real_escape_string($_POST["email"]);
    // $email = $mysqli->real_escape_string($_POST["email"]);: This line takes the user-submitted email from the $_POST array (assuming a form was submitted with an input named "email") and uses the real_escape_string method to escape special characters. This helps prevent SQL injection, a common security vulnerability.

    $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $email);
    // $sql = sprintf("SELECT * FROM user WHERE email = '%s'", $email);: This line creates an SQL query string using the sprintf function. It substitutes the %s placeholder with the escaped email value, creating a safe SQL query to retrieve user data based on the submitted email.

    $result = $mysqli->query($sql);

    // $result = $mysqli->query($sql);: This line executes the SQL query using the query method of the MySQLi object ($mysqli). The result is stored in the $result variable.

    $user = $result->fetch_assoc();
        
    // $user = $result->fetch_assoc();: This line fetches the first row from the result set as an associative array and stores it in the $user variable.
    if ($user) {
       if (password_verify($_POST["password"], $user["password_hash"])){
        die("Login Successful");
        }
    }
}

$is_invalid = true;

?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css"
    />
  </head>
  <body>
    <h1>Login</h1>
    <?php if ($is_invalid): ?>
        <em>Invalid Login</em>
        <?php endif; ?>
    <form method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email">

          <label for="password">Password</label>
        <input type="password" name="password" id="password">

        <button>Log In</button>
    </form>
</body>
</html>