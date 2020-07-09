<?php
require_once 'pdo.php';
session_start();

if ( isset($_POST['delete']) && isset($_POST['auto_id']) ) {
    $sql = "DELETE FROM autos WHERE auto_id = :zip";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':zip' => $_POST['auto_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

if ( !isset($_GET['auto_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT model, auto_id FROM autos where auto_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['auto_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>48e72a50</title>
  </head>
  <body>
     <p>Confirm: Deleting <?= htmlentities($row['model']) ?></p>
    <form method="post">
      <input type="hidden" name="auto_id" value="<?= $row['auto_id'] ?>">
      <input type="submit" value="Delete" name="delete">
      <a href="index.php">Cancel</a>
    </form>
  </body>
</html>
