<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../../config/Database.php';
include_once '../../models/Quote.php';

$database = new Database();
$db = $database->getConnection();
$quote = new Quote($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {

    case 'GET':
        $quote->id = isset($_GET['id']) ? $_GET['id'] : null;
        $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : null;
        $quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;

        $stmt = $quote->read();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
            if ($quote->id) {
                echo json_encode($rows[0]);
            } else {
                echo json_encode($rows);
            }
        } else {
            echo json_encode(['message' => 'No Quotes Found']);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->quote) || empty($data->author_id) || empty($data->category_id)) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            break;
        }

        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        if (!$quote->authorExists()) {
            echo json_encode(['message' => 'author_id Not Found']);
            break;
        }
        if (!$quote->categoryExists()) {
            echo json_encode(['message' => 'category_id Not Found']);
            break;
        }

        if ($quote->create()) {
            echo json_encode([
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id
            ]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id) || empty($data->quote) || empty($data->author_id) || empty($data->category_id)) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            break;
        }

        $quote->id = $data->id;
        $quote->quote = $data->quote;
        $quote->author_id = $data->author_id;
        $quote->category_id = $data->category_id;

        if (!$quote->authorExists()) {
            echo json_encode(['message' => 'author_id Not Found']);
            break;
        }
        if (!$quote->categoryExists()) {
            echo json_encode(['message' => 'category_id Not Found']);
            break;
        }
        if (!$quote->idExists()) {
            echo json_encode(['message' => 'No Quotes Found']);
            break;
        }

        if ($quote->update()) {
            echo json_encode([
                'id' => $quote->id,
                'quote' => $quote->quote,
                'author_id' => $quote->author_id,
                'category_id' => $quote->category_id
            ]);
        } else {
            echo json_encode(['message' => 'No Quotes Found']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id)) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            break;
        }

        $quote->id = $data->id;

        if (!$quote->idExists()) {
            echo json_encode(['message' => 'No Quotes Found']);
            break;
        }

        if ($quote->delete()) {
            echo json_encode(['id' => $quote->id]);
        } else {
            echo json_encode(['message' => 'No Quotes Found']);
        }
    break;
}