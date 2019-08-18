<?php 
session_start();
include_once '../../BL/Redirect.php';
//------------------//
$perm = new Redirect(); 
$perm->redirectAdmin();
if (isset($_POST['logout'])) {
  $perm->logoutUser();
}
// include all files //
include_once '../../DAL/Database.php';
include_once '../../BL/Profile.php';
include_once '../../BL/WorkPlace.php';
//------------------//
$database = new Database();
$db = $database->dbConnect();


  $work = new WorkPlace($db);

  $work->id_radno_mesto = isset($_GET['id_mesto']) ? $_GET['id_mesto'] : die();
  $work->readSingleWork();


  $profile = new Profile($db);

  $profile->id_radnik = $_SESSION['user'];
  $profile->readProfile();

  $stmt = $profile->readWorkProfile();

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Single Works - Dashboard</title>

  <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/dash-bs.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/color.css">

    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/4f38721301.js"></script>

</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

   <!-- sidebar include  -->
   <?php include_once '../../INCLUDES/sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          

          <!-- Topbar Search -->
          <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
              <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
              <div class="input-group-append">
                <button class="btn btn-primary" type="button">
                  <i class="fas fa-search fa-sm"></i>
                </button>
              </div>
            </div>
          </form>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>

            

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $profile->ime . " " . $profile->prezime ?></span>
                <img class="img-profile rounded-circle" src="<?php echo $profile->slika ?>">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="../user/profile.php?id_radnik=<?php echo $profile->id_radnik ?>">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <!-- Page Heading -->
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <a href="updatework.php?edit=<?php echo $work->id_radno_mesto ?>" class="d-none d-sm-inline-block btn  btn-success shadow-sm"> Edit Job</a>
            
            <a onclick="return confirm('Da li ste sigurni')" href="deletework.php?delete=<?php echo $work->id_radno_mesto ?>" class="d-none d-sm-inline-block shadow-sm"> 
              <?php 
            if ($work->ukupno_radnika == 0) {
              echo "<input type = 'submit' class = 'btn btn-danger'  value = 'Delete Workplace'>";
            } else {
               echo "<input type = 'submit' class = 'btn btn-danger'  value = '
                              you cannot delete a job if it has employees' disabled>";
            }

             ?></a>
          
          </div>

        
          <!-- Content Row -->
          <div class="jumbotron jumbotron-fluid darkblue-bg myjumbo ">
  <div class="container">
    <h1 class="display-4"><?php echo $work->naziv; ?></h1>
    <p class="lead desc"><?php echo $work->opis; ?>.</p>
    <p class="jumb">Kreirano: <?php echo $work->kreirano; ?></p>
    <p class="jumb">Ukupno radnika: <span class="broj"> <?php echo $work->ukupno_radnika; ?></span></p>
  </div>
</div>

     <!-- all workers -->
          <div class="all-workers">
            <h2>All Employees</h2>
            <div class="list">
              <div class="row">
              
              <?php 
      while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      
     ?>
                <div class="col-lg-4">
              <div class="card">
  <img src="<?php echo $row['slika']  ?>" class="card-img-top worker-card" alt="...">
  <div class="card-body">
   
    <h5 class="card-title"><?php echo $row['ime'] . ' ' . $row['prezime'] ?></h5>
    <a href="../user/profile.php?id_radnik=<?php echo $row['id_radnik']; ?>" class="btn btn-primary cardbtn">View Profile</a></div>
  </div>
</div>
<?php } ?>
            </div>
          </div>
          </div>
         
          </div> <!-- end of fluid -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2019</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <form method="post">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <input type="submit" class="btn btn-primary" value="Odjavi se" name="logout">
        </form>
        </div>
      </div>
    </div>
  </div>

<!-- Optional JavaScript -->

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
