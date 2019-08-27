<?php 
session_start();
include_once '../../BL/Redirect.php';
//------------------//
$perm = new Redirect(); 
$perm->redirectAdmin();
// include all files //
include_once '../../DAL/Database.php';
include_once '../../BL/WorkPlace.php';
include_once '../../BL/Profile.php';
//------------------//
$database = new Database();
$db = $database->getConnection();

$work = new WorkPlace($db);
$stmt = $work->readAllWork();

if (isset($_POST['submit'])) {
  $profile = new Profile($db);
  $profile->createProfil();
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

    <title>Create Profile!</title>
  </head>
  <body>
     <div class="wrapper fadeInDown">
  <div id="formContent">
    <!-- Tabs Titles -->

    <!-- Icon -->
    <div class="fadeIn first">
        <i class="fas fa-user serviceic"></i>
        <h1>Create Profile</h1>
    </div>

    <!-- Create Form -->
    <form method="post" enctype="multipart/form-data">
     <div class="form-group">
      <div class="row">
        <div class="col-lg-6">
      <label for="username">Name: </label>
       <input type="text" class="form-control" id="name" name="username" autocomplete="off"> <span class="error"></span>
     </div>
     <div class="col-lg-6">
      <label for="lastname">Lastname: </label>
       <input type="text" class="form-control" id="lastname" name="lastname" autocomplete="off"> <span class="error"></span>
     </div>
     </div>
     <div class="row">
        <div class="col-lg-6">
      <label for="email">Email: </label>
       <input type="email" class="form-control" id="email" name="email" autocomplete="off">
       <span class="error"></span>
     </div>
     <div class="col-lg-6">
      <label for="password">Password: </label>
       <input type="password" id="password" class="form-control" name="password" autocomplete="off"><span class="error"></span>
     </div>
     </div>
     <div class="form-group">
      <label for="birthdate">Birth date: </label>
       <input type="date" name="birthdate" id="birth" class="form-control">
     </div><span class="error"></span>
     <div class="form-group">
      <label for="profilepics">Profile Picture : </label>
       <input type="file" id="pics" name="profilepics" size="50" class="form-control">
     </div><span class="error"></span>
      <div class="row">
        <div class="col-lg-6">
      <label for="Telefon">Phone: </label>
       <input type="number" id="telefon" class="form-control" name="telefon" autocomplete="off" min="0"> <span class="error"></span>
     </div>
     <div class="col-lg-6">
      <label for="plata">Salary: </label>
       <input type="number" id="plata" class="form-control" name="plata" autocomplete="off" min="0"><span class="error"></span>
     </div>
     </div>
         <div class="row">
     <div class="col-lg-6">
      <label for="radnomesto">Workplace: </label>
      <select name="radnomesto" id="radno" class="form-control">
        <option value="" selected="" disabled="">Izaberite radno mesto</option>
       <?php 
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
   echo "<option value='" . $row['ID_RADNO_MESTO'] . "'>" . $row['NAZIV'] . "</option>";
}
        ?>
      </select><span class="error"></span>
     </div>
         <div class="col-lg-6">
    <label for="rola">User Roll: </label>
      <select name="rola" id="rola" class="form-control">
        <option value="" selected="" disabled="">Choose Roll</option>
        <option value="5">Admin</option>
        <option value="6">User</option>
      </select><span class="error"></span>
     </div>
     </div>
      <div class="form-group">
        <input type="submit" name="submit" value="CREATE" onclick="return profileValidation();">
      </div>
</div> <!-- form group -->
    </form>

    <!-- Remind Passowrd -->
    <div id="formFooter" class="fadeIn fourth">
      <a class="underlineHover" href="dash.php">Back to Admin Panel?</a>
    </div>

  </div>
</div>


    <!-- Optional JavaScript -->
    <script src="../js/validation.js"></script>
    <!-- validacija za ovu stranicu -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>