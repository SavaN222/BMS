<?php 

class Login {

private $conn;
private $table = 'radnik';

private $email;
private $password;
private $rola;

public function __construct($db) {
	$this->conn = $db;
}
public function loginUser() {
	if (isset($_POST['email'],$_POST['password'])) {
		$email = trim($_POST['email']);
		$password = trim($_POST['password']);
	
		$stmt = $this->getData($email,$password);
		$num = $stmt->rowCount();
		//var_dump($stmt);
		if ($num = 1 ) {
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			$rola = $row['id_rola'];
			$username = $row['ime'];
			$id_radnik = $row['id_radnik'];
		} else {
			echo "<h1>Error</h1>";
		}
		if ($rola == 5) {
			$_SESSION['admin'] = $username;
			$_SESSION['user'] = $id_radnik;
			header("Location: ../admin/dash.php");
			exit();
		} elseif ($rola == 6) {
			$_SESSION['user'] = $id_radnik;
			header("Location: ../user/profile.php?id_radnik=$id_radnik");
			exit();
		} else {
			echo "<h1>Korisnik nije pronadjen</h1>";
		}
	}
}

public function getData($email,$password) {

	$query = "SELECT email,lozinka,id_rola,ime,id_radnik FROM radnik 
	WHERE email = :email AND lozinka = :lozinka";

	// prepare query 
	$stmt = $this->conn->prepare($query);

	// sanitize input
	$this->email = htmlspecialchars(strip_tags($email));
	$this->password = htmlspecialchars(strip_tags($password));

// crypt password
$hashFormat = "2y$10$"; 
$salt = "iusesomecrazystrings22";
$hash_and_salt = $hashFormat . $salt;
$this->password = crypt($this->password, $hash_and_salt);

	$stmt->bindParam(":email", $this->email);
	$stmt->bindParam(":lozinka", $this->password);
	$stmt->execute();



	return $stmt;
} 

} // end of class

 ?>