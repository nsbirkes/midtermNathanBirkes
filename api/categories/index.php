<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

include_once '../../config/Database.php';
include_once '../../models/Category.php';

$database = new Database();
$db = $database->getConnection();
$category = new Category($db);

$method = $_SERVER['REQUEST_METHOD'];

switch($method) {

    case 'GET':
        $category->id = isset($_GET['id']) ? $_GET['id'] : null;
        $stmt = $category->read();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($rows) > 0) {
            if ($category->id) {
                echo json_encode($rows[0]);
            } else {
                echo json_encode($rows);
            }
        } else {
            echo json_encode(['message' => 'category_id Not Found']);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->category)) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            break;
        }

        $category->category = $data->category;

        if ($category->create()) {
            echo json_encode([
                'id' => $category->id,
                'category' => $category->category
            ]);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id) || empty($data->category)) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            break;
        }

        $category->id = $data->id;
        $category->category = $data->category;

        if ($category->update()) {
            echo json_encode([
                'id' => $category->id,
                'category' => $category->category
            ]);
        } else {
            echo json_encode(['message' => 'category_id Not Found']);
        }
        break;

    case 'DELETE':
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->id)) {
            echo json_encode(['message' => 'Missing Required Parameters']);
            break;
        }

        $category->id = $data->id;

        if ($category->delete()) {
            echo json_encode(['id' => $category->id]);
        } else {
            echo json_encode(['message' => 'category_id Not Found']);
        }
        break;
}