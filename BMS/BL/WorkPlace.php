<?php 

class WorkPlace 
{

private $conn;
private $table = 'radno_mesto';

public $id_radno_mesto;
public $naziv;
public $opis;
public $kreirano;
public $ukupno_radnika;

public function __construct($db) {
	$this->conn = $db;
}

public function createWorkPlace() {
	if (isset($_POST['naziv'],$_POST['opis'])) {
		$naziv = trim($_POST['naziv']);
		$opis = trim($_POST['opis']);
	}
	$query = "INSERT INTO " . $this->table . "(naziv,opis) VALUES
	(:naziv,:opis)";

	$stmt = $this->conn->prepare($query);

	// sanitize data //
	$this->naziv = htmlspecialchars(strip_tags($naziv));
	$this->opis = htmlspecialchars(strip_tags($opis));

	// bind param //
	$stmt->bindParam(":naziv",$this->naziv);
	$stmt->bindParam(":opis",$this->opis);

	if ($stmt->execute()) {
		echo "<h1>Radno mesto kreirano</h1>";
	} else {
		echo "GRESKA";
	}

}

public function readAllWork() {


	$query = "SELECT * FROM " . $this->table;

	$stmt = $this->conn->prepare($query);

	$stmt->execute();

	return $stmt;
}

public function sumWork() {


	$query = "SELECT count(id_radno_mesto) as Mesta FROM " . $this->table;

	$stmt = $this->conn->prepare($query);

	$stmt->execute();

	return $stmt;
}

public function readSingleWork() {

	$query = "SELECT m.naziv,m.opis,m.kreirano,count(r.radno_mesto) as ukupno_radnika FROM " . $this->table . " m 
	LEFT JOIN radnik r ON m.id_radno_mesto = r.radno_mesto 
	WHERE m.id_radno_mesto = ? 
	LIMIT 0,1";

	$workstmt = $this->conn->prepare($query);

	$workstmt->bindParam(1,$this->id_radno_mesto);

	$workstmt->execute();

	$rowwork = $workstmt->fetch(PDO::FETCH_ASSOC);

	$this->naziv = $rowwork['naziv'];
	$this->opis = $rowwork['opis'];
	$this->kreirano = $rowwork['kreirano'];
	$this->ukupno_radnika = $rowwork['ukupno_radnika'];
}

public function updateWork($naziv,$opis) {
	$query = "UPDATE " . $this->table . " 
	SET naziv = :naziv, opis = :opis
	WHERE id_radno_mesto = :id";

	$stmt = $this->conn->prepare($query);

	// sanitize param // 
	$this->naziv = htmlspecialchars(strip_tags($naziv));
	$this->opis = htmlspecialchars(strip_tags($opis));

	$stmt->bindParam(":naziv",$this->naziv);
	$stmt->bindParam(":opis",$this->opis);
	$stmt->bindParam(":id",$this->id_radno_mesto);

	$stmt->execute();
}

public function deleteWork() {
	$query = "DELETE FROM " . $this->table . " WHERE id_radno_mesto = ?";

	$stmt = $this->conn->prepare($query);

	$stmt->bindParam(1, $this->id_radno_mesto);

	$stmt->execute();
}


} // end of class

