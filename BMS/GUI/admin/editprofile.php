<?php 
session_start();
// include all files //
include_once '../../DAL/Database.php';
include_once '../../BL/Profile.php';
include_once '../../BL/Redirect.php';
include_once '../../BL/WorkPlace.php';
//------------------//
$perm = new Redirect(); 
$perm->redirectUser();


$database = new Database();
$db = $database->dbConnect();

$work = new WorkPlace($db);
$stmtwork = $work->readAllWork();

$profile = new Profile($db);

$profile->id_radnik = isset($_GET['id_radnik']) ? $_GET['id_radnik'] : die();

$profile->readProfile();


 if (isset($_POST['deleteprofile'])) {
    $profile->deleteProfil();
        header("Location: allworks.php");
        exit();
 }

if (isset($_POST['submit'])) {
   $profile->updateProfil();
    header("Location: ../user/profile.php?id_radnik=$profile->id_radnik");
     exit();
    
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
    <link rel="stylesheet" href="../css/profile.css">

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/4f38721301.js"></script>

    <title>Profile Page!</title>
  </head>
  <body>
    <div class="container emp-profile">
            <form method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img src='<?php echo $profile->slika;  ?>' alt=""/>
                            <div class="file btn btn-lg btn-primary">
                                Change Photo
                                <input type="file" size="50" class="form-control" name="profilepics"/ value="<?php echo $profile->slika ?>">
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
                        <input type="submit" class="profile-edit-btn btn btn-danger" name="deleteprofile" value="Obrisi profil" onclick="return confirm('Da li ste sigurni')" /> <?php } ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-work">
                            <p>STATUS PLATE:</p>
                            <a href=""><?php echo $profile->plata_status; ?></a><br/>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Ime</label>
                                            </div>
                                            <div class="col-md-6">
                                <input type="text" class="form-control" name="ime"
                                value="<?php echo $profile->ime;?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Prezime</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="prezime"
                                value="<?php echo $profile->prezime;?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="telefon"
                                value="<?php echo $profile->telefon;?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                               <input type="text" class="form-control" name="email"
                                value="<?php echo $profile->email;?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Lozinka</label>
                                            </div>
                                            <div class="col-md-6">
                                               <input type="text" class="form-control" name="lozinka"
                                value="nova lozinka">
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Datum rodjenja</label>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" name="datum_rodjenja"
                                value="<?php echo $profile->datum_rodjenja;?>">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Datum zaposlenja</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p><?php echo $profile->datum_zaposlenja; ?></p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Plata</label>
                                            </div>
                                            <div class="col-md-6">
                                               <input type="text" class="form-control" name="plata"
                                value="<?php echo $profile->plata;?>">
                                            </div>
                                        </div>
                                          <div class="row">
                             <div class="col-lg-6">
                              <label for="radno_mesto">Radno Mesto: </label>
                              <select name="radno_mesto" id="" class="form-control">
                                <option value="" selected="" disabled="">Izaberite radno mesto</option>
                               <?php 
                                while ($row = $stmtwork->fetch(PDO::FETCH_ASSOC)) {
                           echo "<option value='" . $row['ID_RADNO_MESTO'] . "'>" . $row['NAZIV'] . "</option>";
                        }
                                ?>
                              </select>
                             </div>
                                 <div class="col-lg-6">
                            <label for="id_rola">Rola: </label>
                              <select name="id_rola" id="" class="form-control">
                                <option value="" selected="" disabled="">Izaberite rolu</option>
                                <option value="5">Administrator</option>
                                <option value="6">Korisnik</option>
                              </select>
                             </div>
                             </div>
                             <hr>
                              <div class="form-group">
                                <input type="submit" class="btn btn-primary" name="submit" value="IZMENI PROFIL">
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