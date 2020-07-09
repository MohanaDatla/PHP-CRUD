<?php
require_once "pdo.php";
session_start();
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title> Mohana Datla 48e72a50 </title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"><!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
  </head>
  <body>
    <div class="container">
      <h1> Welcome to the Automobiles Database </h1>

      <?php
      if (!isset($_SESSION['name'])) {
        echo "<br>";
        echo "<a href='login.php'> Please log in </a>";
        echo "<br> <br>";
        echo "<p> Attempt to <a href='add.php'> add data </a>without logging in. </p>";
      }
      else if (isset($_SESSION['name'])) {
        if (isset($_SESSION['success'])) {
          echo('<p style="color:green;">'.htmlentities($_SESSION['success'])."</p>\n");
          unset($_SESSION['success']);
        }
        $stmt = $pdo->query("SELECT auto_id,make, year, mileage, model FROM autos");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($rows == false) {
          echo "No rows found <br> <br>";
        }
        else {
            echo('<table border="1">'."\n");
            echo ("<thead> <thead><tr>
                  <th>Make</th>
                  <th>Model</th>
                  <th>Year</th>
                  <th>Mileage</th>
                  <th>Action</th>
                  </tr></thead>");
            foreach ($rows as $row) {
              echo "<tr><tr>";
              echo "</td><td>";
              echo (htmlentities($row['year']));
              echo "</td><td>";
              echo (htmlentities($row['model']));
              echo "</td><td>";
              echo (htmlentities($row['make']));
              echo "</td><td>";
              echo (htmlentities($row['mileage']));
              echo "</td><td>";
              echo ('<a href="edit.php?auto_id='.$row['auto_id'].'">Edit</a> / ');
              echo('<a href="delete.php?auto_id='.$row['auto_id'].'">Delete</a>');
              echo("</td></tr>\n");
              }
            echo ("</table>");
            }
            ?>
            <a href="add.php"> Add New Entry </a>
            <br> <br>
            <a href="logout.php"> Logout </a>
<?php
           }
       ?>

    </div>
  </body>
</html>
