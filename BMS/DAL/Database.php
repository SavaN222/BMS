<?php 

class Database {

private $hostname = 'localhost';
private $username = 'root';
private $password = '';
private $db = 'bms';

public $conn;

function dbConnect() {
	$this->conn = null;
	try {
		$this->conn = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->db,
			$this->username,$this->password);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
	} catch (PDOException $e) {
		echo "Connect error " . $e->getMessage();
	}
	return $this->conn;
}

} // end of class

 ?>