<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {

        $query = "SELECT q.id, q.quote, a.author, c.category
                  FROM " . $this->table . " q
                  JOIN authors a ON q.author_id = a.id
                  JOIN categories c ON q.category_id = c.id";

        $conditions = [];
        if ($this->id) $conditions[] = "q.id = :id";
        if ($this->author_id) $conditions[] = "q.author_id = :author_id";
        if ($this->category_id) $conditions[] = "q.category_id = :category_id";
        if ($conditions) $query .= " WHERE " . implode(" AND ", $conditions);

        $stmt = $this->conn->prepare($query);
        if ($this->id) $stmt->bindParam(':id', $this->id);
        if ($this->author_id) $stmt->bindParam(':author_id', $this->author_id);
        if ($this->category_id) $stmt->bindParam(':category_id', $this->category_id);

        $stmt->execute();
        return $stmt;
    }

    public function create() {

        $query = "INSERT INTO " . $this->table . "
                  (quote, author_id, category_id)
                  VALUES (:quote, :author_id, :category_id)
                  RETURNING id";

        $stmt = $this->conn->prepare($query);
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        if ($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            return true;
        }
        return false;
    }

    public function update() {

        $query = "UPDATE " . $this->table . "
                  SET quote = :quote,
                      author_id = :author_id,
                      category_id = :category_id
                  WHERE id = :id";
                  
        $stmt = $this->conn->prepare($query);
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        return $stmt->execute();
    }

    public function delete() {
        $query = "DELETE FROM " . $this->table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }

    public function authorExists() {
        $stmt = $this->conn->prepare("SELECT id FROM authors WHERE id = :id");
        $stmt->bindParam(':id', $this->author_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function categoryExists() {
        $stmt = $this->conn->prepare("SELECT id FROM categories WHERE id = :id");
        $stmt->bindParam(':id', $this->category_id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function idExists() {
        $stmt = $this->conn->prepare("SELECT id FROM quotes WHERE id = :id");
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}