<?php
header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();
$category = new Category($db);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $category->id = $_GET['id'];
            if ($category->read_single()) {
                echo json_encode([
                    'id' => (int)$category->id,
                    'category' => $category->category
                ]);
            } else {
                echo json_encode(['message' => 'category_id Not Found']);
            }
        } else {
            $result = $category->read();
            $categories_arr = [];
            while ($row = $result->fetch()) {
                $categories_arr[] = [
                    'id' => (int)$row['id'],
                    'category' => $row['category']
                ];
            }
            echo json_encode($categories_arr);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->category) || empty(trim($data->category))) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            exit;
        }

        $category->category = $data->category;

        if ($category->create()) {
            echo json_encode([
                'id' => (int)$category->id,
                'category' => $category->category
            ]);
        } else {
            echo json_encode(['message' => 'Category Not Created']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->category) || empty(trim($data->category))) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            exit;
        }

        if (!isset($data->id) || empty(trim($data->id))) {
            echo json_encode(['message' => 'category_id Not Found']);
            exit;
        }

        $category->id = $data->id;
        $category->category = $data->category;

        if ($category->update()) {
            echo json_encode([
                'id' => (int)$category->id,
                'category' => $category->category
            ]);
        } else {
            echo json_encode(['message' => 'category_id Not Found']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || empty(trim($data->id))) {
            echo json_encode(['message' => 'category_id Not Found']);
            exit;
        }

        $category->id = $data->id;

        if ($category->delete()) {
            echo json_encode(['id' => (int)$category->id]);
        } else {
            echo json_encode(['message' => 'category_id Not Found']);
        }
        break;
}
