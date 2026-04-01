<?php
class Quote {
    private $conn;
    private $table = 'quotes';

    public $id;
    public $quote;
    public $author_id;
    public $category_id;
    public $author;
    public $category;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function read() {
        $query = 'SELECT q.id, q.quote, a.author, c.category, q.author_id, q.category_id
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  ORDER BY q.id';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function read_single() {
        $query = 'SELECT q.id, q.quote, a.author, c.category, q.author_id, q.category_id
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.id = :id
                  LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->id);
        $stmt->execute();
        $row = $stmt->fetch();
        if ($row) {
            $this->id = $row['id'];
            $this->quote = $row['quote'];
            $this->author = $row['author'];
            $this->category = $row['category'];
            $this->author_id = $row['author_id'];
            $this->category_id = $row['category_id'];
            return true;
        }
        return false;
    }

    public function read_by_author() {
        $query = 'SELECT q.id, q.quote, a.author, c.category, q.author_id, q.category_id
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.author_id = :author_id
                  ORDER BY q.id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->execute();
        return $stmt;
    }

    public function read_by_category() {
        $query = 'SELECT q.id, q.quote, a.author, c.category, q.author_id, q.category_id
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.category_id = :category_id
                  ORDER BY q.id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->execute();
        return $stmt;
    }

    public function read_by_author_and_category() {
        $query = 'SELECT q.id, q.quote, a.author, c.category, q.author_id, q.category_id
                  FROM ' . $this->table . ' q
                  LEFT JOIN authors a ON q.author_id = a.id
                  LEFT JOIN categories c ON q.category_id = c.id
                  WHERE q.author_id = :author_id AND q.category_id = :category_id
                  ORDER BY q.id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->execute();
        return $stmt;
    }

    public function create() {
        $query = 'INSERT INTO ' . $this->table . ' (quote, author_id, category_id) VALUES (:quote, :author_id, :category_id)';
        $stmt = $this->conn->prepare($query);
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }

    public function update() {
        $query = 'UPDATE ' . $this->table . ' SET quote = :quote, author_id = :author_id, category_id = :category_id WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $stmt->bindParam(':quote', $this->quote);
        $stmt->bindParam(':author_id', $this->author_id);
        $stmt->bindParam(':category_id', $this->category_id);
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
}
