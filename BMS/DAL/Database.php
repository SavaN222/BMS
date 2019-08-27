<?php 

class Database
{
    /**
     * @var string
     */
    private $hostname = 'localhost';

    /**
     * @var string
     */
    private $username = 'root';

    /**
     * @var string
     */
    private $password = '';

    /**
     * @var string
     */
    private $db = 'bms';

    /**
     * @var PDO|null
     */
    private $conn = null;

    /**
     * Get database connection.
     *
     * @return PDO
     */
    public function getConnection()
    {
        if (null === $this->conn) {
            $this->dbConnect();
        }

        return $this->conn;
    }

    /**
     * Establish database connection.
     */
    private function dbConnect()
    {
        try {
            $this->conn = new PDO("mysql:host=" . $this->hostname . ";dbname=" . $this->db,
                $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Connect error ' . $e->getMessage());
        }
    }
}
