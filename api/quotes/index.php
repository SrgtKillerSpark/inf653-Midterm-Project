<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'OPTIONS') {
    http_response_code(200);
    exit;
}

include_once '../../config/Database.php';
include_once '../../models/Quote.php';
include_once '../../models/Author.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->connect();
$quote = new Quote($db);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $quote->id = $_GET['id'];
            if ($quote->read_single()) {
                echo json_encode([
                    'id' => (int)$quote->id,
                    'quote' => $quote->quote,
                    'author' => $quote->author,
                    'category' => $quote->category
                ]);
            } else {
                echo json_encode(['message' => 'No Quotes Found']);
            }
        } elseif (isset($_GET['author_id']) && isset($_GET['category_id'])) {
            $quote->author_id = $_GET['author_id'];
            $quote->category_id = $_GET['category_id'];
            $result = $quote->read_by_author_and_category();
            $quotes_arr = [];
            while ($row = $result->fetch()) {
                $quotes_arr[] = [
                    'id' => (int)$row['id'],
                    'quote' => $row['quote'],
                    'author' => $row['author'],
                    'category' => $row['category']
                ];
            }
            if (count($quotes_arr) > 0) {
                echo json_encode($quotes_arr);
            } else {
                echo json_encode(['message' => 'No Quotes Found']);
            }
        } elseif (isset($_GET['author_id'])) {
            $quote->author_id = $_GET['author_id'];
            $result = $quote->read_by_author();
            $quotes_arr = [];
            while ($row = $result->fetch()) {
                $quotes_arr[] = [
                    'id' => (int)$row['id'],
                    'quote' => $row['quote'],
                    'author' => $row['author'],
                    'category' => $row['category']
                ];
            }
            if (count($quotes_arr) > 0) {
                echo json_encode($quotes_arr);
            } else {
                echo json_encode(['message' => 'No Quotes Found']);
            }
        } elseif (isset($_GET['category_id'])) {
            $quote->category_id = $_GET['category_id'];
            $result = $quote->read_by_category();
            $quotes_arr = [];
            while ($row = $result->fetch()) {
                $quotes_arr[] = [
                    'id' => (int)$row['id'],
                    'quote' => $row['quote'],
                    'author' => $row['author'],
                    'category' => $row['category']
                ];
            }
            if (count($quotes_arr) > 0) {
                echo json_encode($quotes_arr);
            } else {
                echo json_encode(['message' => 'No Quotes Found']);
            }
        } else {
            $result = $quote->read();
            $quotes_arr = [];
            while ($row = $result->fetch()) {
                $quotes_arr[] = [
                    'id' => (int)$row['id'],
                    'quote' => $row['quote'],
                    'author' => $row['author'],
                    'category' => $row['category']
                ];
            }
            echo json_encode($quotes_arr);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)
            || empty(trim($data->quote)) || empty(trim($data->author_id)) || empty(trim($data->category_id))) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            exit;
        }

        // Check author_id exists
        $author = new Author($db);
        $author->id = $data->author_id;
        if (!$author->exists()) {
            echo json_encode(['message' => 'author_id Not Found']);
            exit;
        }

        // Check category_id exists
        $category = new Category($db);
        $category->id = $data->category_id;
        if (!$category->exists()) {
            echo json_encode(['message' => 'category_id Not Found']);
            exit;
        }

        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        if ($quote->create()) {
            echo json_encode([
                'id' => (int)$quote->id,
                'quote' => $quote->quote,
                'author_id' => (int)$quote->author_id,
                'category_id' => (int)$quote->category_id
            ]);
        } else {
            echo json_encode(['message' => 'Quote Not Created']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)
            || empty(trim($data->quote)) || empty(trim($data->author_id)) || empty(trim($data->category_id))) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            exit;
        }

        if (!isset($data->id) || empty(trim($data->id))) {
            echo json_encode(['message' => 'No Quotes Found']);
            exit;
        }

        // Check author_id exists
        $author = new Author($db);
        $author->id = $data->author_id;
        if (!$author->exists()) {
            echo json_encode(['message' => 'author_id Not Found']);
            exit;
        }

        // Check category_id exists
        $category = new Category($db);
        $category->id = $data->category_id;
        if (!$category->exists()) {
            echo json_encode(['message' => 'category_id Not Found']);
            exit;
        }

        $quote->id = $data->id;
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        if ($quote->update()) {
            echo json_encode([
                'id' => (int)$quote->id,
                'quote' => $quote->quote,
                'author_id' => (int)$quote->author_id,
                'category_id' => (int)$quote->category_id
            ]);
        } else {
            echo json_encode(['message' => 'No Quotes Found']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (!isset($data->id) || empty(trim($data->id))) {
            echo json_encode(['message' => 'No Quotes Found']);
            exit;
        }

        $quote->id = $data->id;

        if ($quote->delete()) {
            echo json_encode(['id' => (int)$quote->id]);
        } else {
            echo json_encode(['message' => 'No Quotes Found']);
        }
        break;
}
