<?php
class Database {
    private $conn;

    public function connect() {
        $this->conn = null;

        // Check for DATABASE_URL (Render / Heroku PostgreSQL)
        $database_url = getenv('DATABASE_URL');

        try {
            if ($database_url) {
                $params = parse_url($database_url);
                $dbname = ltrim($params['path'], '/');
                $host = $params['host'];
                $port = isset($params['port']) ? $params['port'] : 5432;
                $user = $params['user'];
                $pass = $params['pass'];
                $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
                $this->conn = new PDO($dsn, $user, $pass);
            } else {
                // Local MySQL (XAMPP)
                $host = 'localhost';
                $db_name = 'quotesdb';
                $username = 'root';
                $password = '';
                $dsn = "mysql:host=$host;dbname=$db_name;charset=utf8";
                $this->conn = new PDO($dsn, $username, $password);
            }
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo json_encode(['message' => 'Database Connection Error: ' . $e->getMessage()]);
            exit;
        }

        return $this->conn;
    }
}
