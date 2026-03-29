<?php
class Database {
    private $host = 'dpg-d747g16a2pns73ah15d0-a.oregon-postgres.render.com';
    private $port = '5432';
    private $db_name = 'quotesdb_o2u6';
    private $username = 'quotesdb_o2u6_user';
    private $password = 'wnSUb8Ulz5SHpaIuv3AnSLtx8igKdQ5s';
    public  $conn;

    public function getConnection() {
        
        $this->conn = null;

        try {
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";
            $this->conn = new PDO($dsn, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch(PDOException $e) {
            echo json_encode(['message' => 'Connection Error: ' . $e->getMessage()]);
        }

        return $this->conn;
    }
}