<?php 
session_start();
include_once '../../BL/Redirect.php';
//------------------//
$perm = new Redirect(); 
$perm->redirectAdmin();
// include all files //
include_once '../../DAL/Database.php';
include_once '../../BL/WorkPlace.php';
//------------------//
$database = new Database();
$db = $database->dbConnect();

if (isset($_POST['submit'])) {
  $work = new WorkPlace($db);
  $work->createWorkPlace();
}
 ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/landing.css">
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/4f38721301.js"></script>

    <title>Create Workplace!</title>
  </head>
  <body>
     <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
        <i class="fas fa-city serviceic"></i>
        <h1>Create Workplace</h1>
    </div>

    <!-- Create Form -->
    <form method="post">
      <div class="form-group fadeIn second">
        <label for="naziv">Workplace Name:</label>
        <input type="text" id="radno" name="naziv" class="form-control bg-dark text-white">
        <span class="error"></span>
      </div>
      <div class="form-group fadeIn third">
        <label for="opis">Description:</label>
       <textarea class="form-control bg-dark text-white" id="opis" rows="5" id="comment" name="opis"></textarea><span class="error"></span>
      </div>
      <div class="form-group">
        <input type="submit" name="submit" value="KREIRAJ" onclick="return workValidation();">
      </div>

    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter" class="fadeIn fourth">
      <a class="underlineHover" href="dash.php">Back to Admin Panel?</a>
    </div>

  </div>
</div>


    <!-- Optional JavaScript -->
    <script src="../js/validation.js"></script>
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>