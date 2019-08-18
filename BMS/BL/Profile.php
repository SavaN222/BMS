<?php 

class Profile {

private $conn;
private $table = "radnik";

public $id_radnik;
public $ime;
public $prezime;
public $telefon;
public $email;
public $lozinka;
public $datum_rodjenja;
public $datum_zaposlenja;
public $slika;
public $plata;
public $poslednja_plata;
public $sledeca_plata;
public $radno_mesto;
public $plata_status;
public $rola;
public $id_plata;

public function __construct($db) {
	$this->conn = $db;
}

public function readProfile() {

	$this->id_plata = $this->checkSalary();

	$query = "SELECT r.ime,r.prezime,r.telefon,r.email,r.lozinka,r.datum_rodjenja,r.datum_zaposlenja,r.slika,r.plata,r.poslednja_plata,r.sledeca_plata,r.id_plata, 
	m.naziv,p.status 
	FROM ((" . $this->table . " r LEFT JOIN radno_mesto m ON r.radno_mesto = m.id_radno_mesto)
	LEFT JOIN plata_status p ON r.id_plata = p.id_plata) 
	WHERE r.id_radnik = ? 
	LIMIT 0,1";

	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $this->id_radnik);

	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$this->ime = $row['ime'];
	$this->prezime = $row['prezime'];
	$this->telefon = $row['telefon'];
	$this->email = $row['email'];
	$this->lozinka = $row['lozinka'];
	$this->datum_rodjenja = $row['datum_rodjenja'];
	$this->datum_zaposlenja = $row['datum_zaposlenja'];
	$this->slika = $row['slika'];
	$this->plata = $row['plata'];
	$this->poslednja_plata = $row['poslednja_plata'];
	$this->sledeca_plata = $row['sledeca_plata'];
	$this->radno_mesto = $row['naziv'];
	$this->plata_status = $row['status'];
}

public function updateSalary() {
	$query = "UPDATE " . $this->table . " SET
	 poslednja_plata = current_date(),
	sledeca_plata = current_date() + interval 30 day
		WHERE id_radnik = ?";

	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $this->id_radnik);

	$stmt->execute();
}

public function checkSalary() {

	$query = "SELECT sledeca_plata 
	FROM " . $this->table . "  
	WHERE id_radnik = ?";

	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $this->id_radnik);

	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);

	$this->sledeca_plata = $row['sledeca_plata'];

	$today_time = new DateTime(date("Y/m/d"));
	$expire_time = new DateTime($this->sledeca_plata);

	if ($today_time > $expire_time) {
		$this->id_plata = 2;
		$update_query = "UPDATE " . $this->table . " SET id_plata = ? 
		WHERE id_radnik = ?";
		$stmt_up = $this->conn->prepare($update_query);

		$stmt_up->bindParam(1,$this->id_plata);

		$stmt_up->bindParam(2,$this->id_radnik);

			$stmt_up->execute();
	} else {
		$this->id_plata = 1;
		$update_query = "UPDATE " . $this->table . " SET id_plata = ? 
		WHERE id_radnik = ?";
		$stmt_up = $this->conn->prepare($update_query);

		$stmt_up->bindParam(1,$this->id_plata);

		$stmt_up->bindParam(2,$this->id_radnik);

			$stmt_up->execute();
	}
	return $this->id_plata;
}

public function createProfil() {
$ime = $_POST['username'];
$prezime = $_POST['lastname'];
$email = $_POST['email'];
$lozinka = $_POST['password'];
$datum_rodjenja = $_POST['birthdate'];
$telefon = $_POST['telefon'];
$plata = $_POST['plata'];
$rola = $_POST['rola'];
$radno_mesto = $_POST['radnomesto'];
$img = $_FILES['profilepics'];

$img_upload = $this->imgUpload($img);

$query = "INSERT INTO " . $this->table . "(ime,prezime,email,lozinka,datum_rodjenja,datum_zaposlenja,telefon,slika,plata,id_rola,radno_mesto,id_plata,POSLEDNJA_PLATA,SLEDECA_PLATA) VALUES(
:ime,
:prezime,
:email,
:lozinka,
:datum_rodjenja,
current_date(),
:telefon,
:slika,
:plata,
:rola,
:radno_mesto,
1,
current_date(),
current_date() + interval 30 day
)";

$stmt = $this->conn->prepare($query);

// Sanitize // 
	$this->ime = htmlspecialchars(strip_tags($ime));
	$this->prezime = htmlspecialchars(strip_tags($prezime)); 
	$this->email = htmlspecialchars(strip_tags($email));
	$this->lozinka = htmlspecialchars(strip_tags($lozinka)); 
	$this->datum_rodjenja = htmlspecialchars(strip_tags($datum_rodjenja)); 
	$this->telefon = htmlspecialchars(strip_tags($telefon)); 
	$this->slika = $img_upload;
	$this->plata = htmlspecialchars(strip_tags($plata));
	$this->rola = $rola;
	$this->radno_mesto = $radno_mesto;

// crypt password
$hashFormat = "2y$10$"; 
$salt = "iusesomecrazystrings22";
$hash_and_salt = $hashFormat . $salt;
$this->lozinka = crypt($this->lozinka, $hash_and_salt);
	// bind params // 

	$stmt->bindParam(":ime",$this->ime);
	$stmt->bindParam(":prezime",$this->prezime);
	$stmt->bindParam(":email",$this->email);
	$stmt->bindParam(":lozinka",$this->lozinka);
	$stmt->bindParam(":datum_rodjenja",$this->datum_rodjenja);
	$stmt->bindParam(":telefon",$this->telefon);
	$stmt->bindParam(":slika",$this->slika);
	$stmt->bindParam(":plata",$this->plata);
	$stmt->bindParam(":rola",$this->rola);
	$stmt->bindParam(":radno_mesto",$this->radno_mesto);

	if ($stmt->execute()) {
		echo "<h1>Profil kreiran</h1>";
	} else {
		echo "<h1>GRESKA</h1>";
	}
}

public function imgUpload($img) {
	$filePath = '';
	$allowedExtensions = ['jpg','png'];
	$allowedTypes = ['image/jpeg','image/png','image/pjpeg'];

	$imageNameArray = explode(".", $img["name"]);
	$fileExtensions = end($imageNameArray);
	$newfilename = $imageNameArray[0] .  round(microtime(true)) . '.' . $fileExtensions;


	if ($img["size"] <= 376832 && in_array($fileExtensions, $allowedExtensions)
      && in_array($img["type"], $allowedTypes)) {


		
		$filePath = sprintf("../imgprofile/%s",$newfilename);
		if (!file_exists($filePath)) {
			$isSuccessfull = move_uploaded_file($img['tmp_name'], $filePath);
		} else {
			$filePath = '';
		}
	}
	return $filePath;
}

public function readWorkProfile() {
	$id_mesto = $_GET['id_mesto'];

	$query = "SELECT ime,prezime,id_radnik,slika FROM " . $this->table . " WHERE radno_mesto = :mesto";

	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(":mesto",$id_mesto);

	$stmt->execute();

	return $stmt;
}

public function updateProfil() {
$ime = $_POST['ime'];
$prezime = $_POST['prezime'];
$email = $_POST['email'];
$lozinka = $_POST['lozinka'];
$datum_rodjenja = $_POST['datum_rodjenja'];
$telefon = $_POST['telefon'];
$img = $_FILES['profilepics'];
$plata = $_POST['plata'];
$rola = $_POST['id_rola'];
$radno_mesto = $_POST['radno_mesto'];

$hashFormat = "2y$10$"; 
$salt = "iusesomecrazystrings22";
$hash_and_salt = $hashFormat . $salt;
$lozinka = crypt($lozinka, $hash_and_salt);

$slika = $this->imgUpload($img);


	$query = "UPDATE " . $this->table . " 
	SET ime = :ime,
	prezime = :prezime,
	email = :email,
	lozinka = :lozinka,
	datum_rodjenja = :datum_rodjenja,
	telefon = :telefon,
	slika = :slika,
	plata = :plata,
	id_rola = :id_rola,
	radno_mesto = :radno_mesto
	WHERE id_radnik = :id";

	$stmt = $this->conn->prepare($query);

	// sanitize param // 
// Sanitize // 
	$this->ime = htmlspecialchars(strip_tags($ime));
	$this->prezime = htmlspecialchars(strip_tags($prezime)); 
	$this->email = htmlspecialchars(strip_tags($email));
	$this->lozinka = htmlspecialchars(strip_tags($lozinka)); 
	$this->datum_rodjenja = htmlspecialchars(strip_tags($datum_rodjenja)); 
	$this->telefon = htmlspecialchars(strip_tags($telefon)); 
	$this->slika = $slika;
	$this->plata = htmlspecialchars(strip_tags($plata));
	$this->rola = $rola;
	$this->radno_mesto = $radno_mesto;

	// bind params // 

	$stmt->bindParam(":ime",$this->ime);
	$stmt->bindParam(":prezime",$this->prezime);
	$stmt->bindParam(":email",$this->email);
	$stmt->bindParam(":lozinka",$this->lozinka);
	$stmt->bindParam(":datum_rodjenja",$this->datum_rodjenja);
	$stmt->bindParam(":telefon",$this->telefon);
	$stmt->bindParam(":slika",$this->slika);
	$stmt->bindParam(":plata",$this->plata);
	$stmt->bindParam(":id_rola",$this->rola);
	$stmt->bindParam(":radno_mesto",$this->radno_mesto); 
	$stmt->bindParam(":id",$this->id_radnik);

	if ($stmt->execute()) {
		echo "<h1>Rekord kreiran</h1>";
	} else {
		echo "<h1>Greska</h1>";

	}
}

public function deleteProfil() {
	$query = "DELETE FROM " . $this->table . " WHERE id_radnik = ?";

	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $this->id_radnik);

	$stmt->execute();
}

public function employees() {
	$query = "SELECT count(id_radnik) as Zaposlenih FROM " . $this->table;

	$stmt = $this->conn->prepare($query);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$zaposlenih = $row['Zaposlenih'];
	return $zaposlenih;
}

public function readAllProfiles() {

	$query = "SELECT ime,prezime,id_radnik,slika,id_plata FROM " . $this->table;

	$stmt = $this->conn->prepare($query);

	$stmt->execute();

	return $stmt;
}

public function searchProfile($keywords) {
	$query = "SELECT ime,prezime,id_radnik,slika FROM " . $this->table . " WHERE
	ime LIKE ? OR prezime LIKE ?";

	$stmt = $this->conn->prepare($query);

	// sanitize 
	$keywords = htmlspecialchars(strip_tags($keywords));
	$keywords = "%{$keywords}%";

	// bind 
	$stmt->bindParam(1, $keywords);
	$stmt->bindParam(2, $keywords);

	$stmt->execute();

	return $stmt;


}

public function paidWorkers() {
	$query = "SELECT count(ID_PLATA) as Placeni FROM " . $this->table . " 
	WHERE id_plata = 1";

	$stmt = $this->conn->prepare($query);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$placeni = $row['Placeni'];

	return $placeni;
	
}

public function unpaidWorkers() {
	$query = "SELECT count(ID_PLATA) as Neplaceni FROM " . $this->table . " 
	WHERE id_plata = 2";

	$stmt = $this->conn->prepare($query);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$neplaceni = $row['Neplaceni'];
	
	return $neplaceni;
	
}

public function sumPaidWorkers() {
	$query = "SELECT sum(plata) as Ukupno FROM " . $this->table . " 
	WHERE id_plata = 1";

	$stmt = $this->conn->prepare($query);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$ukupno = $row['Ukupno'];
	
	return $ukupno;
}
public function sumUnpaidWorkers() {
	$query = "SELECT sum(plata) as Ukupno FROM " . $this->table . " 
	WHERE id_plata = 2";

	$stmt = $this->conn->prepare($query);
	$stmt->execute();

	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	$ukupno = $row['Ukupno'];
	
	return $ukupno;
}

public function unpaidTable() {
	$query = "SELECT ime,prezime,plata,id_radnik,id_plata FROM " . $this->table . " 
	WHERE id_plata = 2 
	ORDER BY plata	DESC";

	$stmt = $this->conn->prepare($query);

	$stmt->execute();

	return $stmt;
}

} // end of class
 ?>