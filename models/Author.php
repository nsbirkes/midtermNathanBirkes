<?php
class Author {
    private $conn;
    private $table = 'authors';

    public $id;
    public $author;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {

        $query = "SELECT id, author FROM " . $this->table;

        if ($this->id) $query .= " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        
        if ($this->id) $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        
        return $stmt;
    }

    public function create() {
        
        $query = "INSERT INTO " . $this->table . "
                (author) VALUES (:author) RETURNING id";
        
        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author));
        $stmt->bindParam(':author', $this->author);
        
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }
        
        return false;
    }

    public function update() {

        $query = "UPDATE " . $this->table . "
                SET author = :author WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':author', $this->author);

        return $stmt->execute();
    }

    public function delete() {

        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        
        return $stmt->execute();
    }
}