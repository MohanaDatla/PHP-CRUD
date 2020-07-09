<?php
require_once "pdo.php";
session_start();

if (!isset($_SESSION['name']))
{
  die('ACCESS DENIED');
}

if (isset($_POST['cancel']) == 'cancel') {
  header("Location: index.php");
  return;
}

if ( ! isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing auto_id";
  header('Location: index.php');
  return;
}

if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage']) && isset($_POST['model'])) {
  if (!is_numeric($_POST['year'])) {
    $_SESSION['error'] = "Year must be numeric";
    header("Location: edit.php");
    return;
  }
  else if (!is_numeric($_POST['mileage'])) {
    $_SESSION['error'] = "Mileage must be numeric";
    header("Location: edit.php");
    return;
  }
  else if ((strlen($_POST['make'])) <1 || (strlen($_POST['model'])) < 1 || (strlen($_POST['year'])) < 1 || (strlen($_POST['mileage']))<1) {
    $_SESSION['error'] = "All fields are required";
    header("Location: edit.php");
    return;
  }
  else {
    $stmt = $pdo->prepare("UPDATE autos SET make = :mk ,model = :mo ,year = :yr,mileage = :mi WHERE auto_id = :auto_id");
    $stmt->execute(array(
      ':mk' => $_POST['make'],
      ':mo' => $_POST['model'],
      ':yr' => $_POST['year'],
      ':mi' => $_POST['mileage'],
      ':auto_id' => $_POST['auto_id']));
    $_SESSION['success'] = "Record updated";
    header("Location: index.php");
    return;
  }
 }


$stmt = $pdo->prepare("SELECT * FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for auto_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$make = htmlentities($row['make']);
$model = htmlentities($row['model']);
$year = htmlentities($row['year']);
$mileage = htmlentities($row['mileage']);
$auto_id = $row['auto_id'];


 ?>


<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> 48e72a50 </title>
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
    <h1> Editing Automobile </h1>

    <?php
    if (isset($_SESSION['error'])) {
      echo "<p style='color:red'>".$_SESSION['error']."</p>\n";
      unset($_SESSION['error']);
    }
     ?>
    <form method="post">
    <label for=""> Make: </label>
    <input type="text" name="make" value="<?= $make ?>"><br><br>
    <label for=""> Model: </label>
    <input type="text" name="model" value="<?= $model ?>"><br><br>
    <label for=""> Year : </label>
    <input type="text" name="year" value="<?= $year ?>"><br><br>
    <label for=""> Mileage : </label>
    <input type="text" name="mileage" value=" <?= $mileage ?>"><br><br>
    <input type="hidden" name="auto_id" value="<?= $auto_id ?>">
    <button type="submit" value="Save"> Save </button>
    <button type="submit" value="cancel" name="cancel"> Cancel </button>
    </form>
  </body>
</html>
