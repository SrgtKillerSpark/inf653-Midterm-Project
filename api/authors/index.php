<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');
    http_response_code(200);
    exit;
}

include_once '../../config/Database.php';
include_once '../../models/Author.php';

$database = new Database();
$db = $database->connect();
$author = new Author($db);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $author->id = $_GET['id'];
            if ($author->read_single()) {
                echo json_encode([
                    'id' => (int)$author->id,
                    'author' => $author->author
                ]);
            } else {
                echo json_encode(['message' => 'author_id Not Found']);
            }
        } else {
            $result = $author->read();
            $authors_arr = [];
            while ($row = $result->fetch()) {
                $authors_arr[] = [
                    'id' => (int)$row['id'],
                    'author' => $row['author']
                ];
            }
            echo json_encode($authors_arr);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author) || empty(trim($data->author))) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            exit;
        }

        $author->author = $data->author;

        if ($author->create()) {
            echo json_encode([
                'id' => (int)$author->id,
                'author' => $author->author
            ]);
        } else {
            echo json_encode(['message' => 'Author Not Created']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->author) || empty(trim($data->author))) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            exit;
        }

        if (!isset($data->id) || empty(trim($data->id))) {
            echo json_encode(['message' => 'author_id Not Found']);
            exit;
        }

        $author->id = $data->id;
        $author->author = $data->author;

        if ($author->update()) {
            echo json_encode([
                'id' => (int)$author->id,
                'author' => $author->author
            ]);
        } else {
            echo json_encode(['message' => 'author_id Not Found']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || empty(trim($data->id))) {
            echo json_encode(['message' => 'author_id Not Found']);
            exit;
        }

        $author->id = $data->id;

        if ($author->delete()) {
            echo json_encode(['id' => (int)$author->id]);
        } else {
            echo json_encode(['message' => 'author_id Not Found']);
        }
        break;
}
