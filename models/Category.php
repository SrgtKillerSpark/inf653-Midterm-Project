<?php
class Category {
    private $conn;
    private $table = 'categories';

    public $id;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT id, category FROM ' . $this->table . ' ORDER BY id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->category = $row['category'];
            return true;
        }
        return false;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';
        $stmt = $this->conn->prepare($query);
        $this->category = htmlspecialchars(strip_tags($this->category));
        $stmt->bindParam(':category', $this->category);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET category = :category WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->category = htmlspecialchars(strip_tags($this->category));
        $this->id = htmlspecialchars(strip_tags($this->id));
        $stmt->bindParam(':category', $this->category);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        }
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
