<?php
require_once "pdo.php";
session_start();
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123
$failure = false;
if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION['error'] = "Email and password are required";
        header("Location: login.php");
        return;
    }
    else {
      if (!filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
      {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        return;
      }
      else {
        $check = hash('md5', $salt.$_POST['pass']);
          if($check!= $stored_hash) {
                  $_SESSION['error'] = "Incorrect Password";
                  header("Location: login.php");
                  return;
          }
            else {
              if($check == $stored_hash){
                // Redirect the browser to view.php
                $_SESSION['name'] = $_POST['email'];
                $_SESSION['success'] = "Logged in.";
                header("Location: index.php");
                return;
                error_log("Login success ".$_POST['email']);
            }
          }
          }
        }
        }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> Mohana Datla Login Page 48e72a50 </title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><!-- Optional theme -->

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

  </head>
  <body>
    <div class="container">
    <h1> Please Log In </h1>
    <?php
    if (isset($_SESSION['error'])) {
      echo ('<p style="color:red;">' .htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
    }
     ?>
    <form method="post">
    <label for="Name"> Email: </label>
    <input type="text" id="email" name="email"> <br>
    <label for="id_1723">Password: </label>
    <input type="text" name="pass" id="id_1723"> <br>
    <input type="submit" value="Log In">
    <a href="cancel.php"> Cancel </a>
    </form>
    <p>
    For a password hint, view source and find a password hint in the HTML comments.
    </p>
    </div>
  </body>
</html>
