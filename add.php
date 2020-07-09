<?php
require_once "pdo.php";
session_start();
$email = isset($_SESSION['name']);
$insertion = FALSE;
$failure = FALSE;

if (!isset($_SESSION['name']))
{
  die('ACCESS DENIED');
}

if (isset($_POST['cancel']) == 'cancel') {
  header("Location: index.php");
  return;
}

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model'])) {
  if ((strlen($_POST['make'])) <1 || (strlen($_POST['model'])) < 1 || (strlen($_POST['year'])) < 1 || (strlen($_POST['mileage']))<1) {
    $_SESSION['error'] = "All fields are required";
    header("Location: add.php");
    return;
  }
  else if (!is_numeric($_POST['mileage'])) {
    $_SESSION['error'] = "Mileage must be numeric";
    header("Location: add.php");
    return;
  }
  else if (!is_numeric($_POST['year'])) {
    $_SESSION['error'] = "Year must be numeric";
    header("Location: add.php");
    return;
  }
  else {
    $stmt = $pdo->prepare("INSERT INTO autos(make,model,year,mileage) VALUES (:mk, :mo, :yr, :mi)");
    $stmt->execute(array(
      ':mk' => $_POST['make'],
      ':mo' => $_POST['model'],
      ':yr' => $_POST['year'],
      ':mi' => $_POST['mileage'])
    );
    $_SESSION['success'] = "added";
    header("Location: index.php");
    return;
  }
 }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> Mohana Datla 48e72a50 </title>

    <link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
    integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7"
    crossorigin="anonymous">

<link rel="stylesheet"
    href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
    integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r"
    crossorigin="anonymous">

<link rel="stylesheet"
    href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css">

<script
  src="https://code.jquery.com/jquery-3.2.1.js"
  integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE="
  crossorigin="anonymous"></script>

<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
  integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30="
  crossorigin="anonymous"></script>

  </head>
  <body>
    <h1> Tracking Automobiles for <?php echo $_SESSION['name']; ?></h1>

    <?php
    if (isset($_SESSION['error'])) {
      echo ('<p style="color:red;">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
    }
    ?>

    <form method="post">
    <label for="make"> Make: </label>
    <input type="text" name="make" value=""><br><br>
    <label for="model"> Model: </label>
    <input type="text" name="model" value="">
    <br><br>
    <label for="year"> Year : </label>
    <input type="text" name="year" value=""><br><br>
    <label for="mileage"> Mileage : </label>
    <input type="text" name="mileage" value=""><br><br>
    <button type="submit" value="Add"> Add </button>
    <button type="submit" value="cancel" name="cancel"> Cancel </button>
    </form>
  </body>
</html>
