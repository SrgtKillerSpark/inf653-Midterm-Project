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
        $query = 'SELECT id, author FROM ' . $this->table . ' ORDER BY id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->author = $row['author'];
            return true;
        }
        return false;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author)';
        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author));
        $stmt->bindParam(':author', $this->author);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET author = :author WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
        // Check if the row exists but data is the same
        $check = $this->conn->prepare('SELECT id FROM ' . $this->table . ' WHERE id = :id');
        $check->bindParam(':id', $this->id);
        $check->execute();
        return $check->rowCount() > 0;
    }

    public function delete() {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function exists() {
        $query = 'SELECT id FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }
}
