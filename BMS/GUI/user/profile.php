<?php 
session_start();
// include all files //
include_once '../../DAL/Database.php';
include_once '../../BL/Profile.php';
include_once '../../BL/Redirect.php';
//------------------//
$database = new Database();
$db = $database->getConnection();

$profile = new Profile($db);

$profile->id_radnik = isset($_GET['id_radnik']) ? $_GET['id_radnik'] : die();

if (isset($_POST['submit'])) {
$profile->updateSalary();
}

$profile->readProfile();

$perm = new Redirect(); 
$perm->redirectUser();

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
    <link rel="stylesheet" href="../css/profile.css">

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/4f38721301.js"></script>

    <title>Profile Page!</title>
  </head>
  <body>
    <div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src='<?php echo $profile->slika;  ?>' alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                        <?php echo $profile->ime . " " . $profile->prezime; ?>
                                    </h5>
                                    <h6>
                                        <?php echo $profile->radno_mesto; ?>
                                    </h6>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <?php if (isset($_SESSION['admin'])) {
                       ?>
                        <a href="../admin/editprofile.php?id_radnik=<?php echo $profile->id_radnik ?>" class="btn btn-info">Edit Profile</a>
                         <?php } 
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                             <?php if (isset($_SESSION['admin'])) {
                       ?>
                       <a href="../admin/dash.php" class="btn btn-secondary btn-lg active btn-sm" role="button" aria-pressed="true">Admin Panel</a>
                         <?php } else { ?>
                         <a href="../landing/index.html" class="btn btn-secondary btn-lg active btn-sm" role="button" aria-pressed="true">Home</a>   
                         <?php } ?>
                            <h4>SALARY STATUS:</h4>
                            <?php if ($profile->id_plata == 1) {
                                echo "<p class='placeno'>" . $profile->plata_status . "</p>";
                            } else {
                     echo "<p class='neplaceno'>" . $profile->plata_status . "</p>";
                                if (isset($_SESSION['admin'])) {
                echo "<input type='submit' class='form-control btn btn-warning'
                name = 'submit' value = 'PAY'>";
                            }} ?>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php 
                                                echo $profile->ime;
                                                 ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Lastname</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->prezime; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->telefon; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->email ?></p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Birth date</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->datum_rodjenja; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Date of employment</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->datum_zaposlenja; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Salary</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->plata; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Last Salary</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->poslednja_plata; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Next Salary</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->sledeca_plata ?></p>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>


    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>