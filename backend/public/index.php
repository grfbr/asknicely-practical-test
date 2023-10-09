<?php
require_once '../controllers/EmployeeController.php';

$controller = new EmployeeController();

$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];
$path = parse_url($requestUri, PHP_URL_PATH);

function sendResponse($data, $status = 200)
{
    http_response_code($status);
    echo json_encode($data);
}

header('Content-Type: application/json; charset=utf-8');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

if ($requestMethod == 'OPTIONS') { // Preflight request. Reply successfully:
    exit(0);
}

switch ($requestMethod) {
    case 'GET':
        if ($path == '/employees') {
            try {
                sendResponse($controller->listEmployees());
            } catch (Exception $e) {
                sendResponse(['message' => $e->getMessage()], 500);
            }
        } elseif ($path == '/average-salary') {
            sendResponse($controller->showAverageSalary());
        } else {
            sendResponse(['message' => 'AskNicely API']);
        }
        break;

    case 'PUT':
        $data = json_decode(file_get_contents("php://input"));
        if ($path == '/edit-email') {
            try {
                sendResponse(['status' => $controller->editEmployeeEmail($data->id, $data->email)]);
            } catch (Exception $e) {
                sendResponse(['message' => $e->getMessage()], 500);
            }
        } else {
            sendResponse(['message' => 'AskNicely API']);
        }
        break;

    case 'POST':
        if ($path == '/import-csv') {
            if (isset($_FILES['csvFile']) && $_FILES['csvFile']['error'] == UPLOAD_ERR_OK) {
                $uploadedFilePath = $_FILES['csvFile']['tmp_name'];
                $controller->importCSV($uploadedFilePath);
                sendResponse(['message' => 'CSV imported successfully.']);
            } else {
                sendResponse(['error' => 'Failed to upload CSV.'], 500);
            }
        } else {
            sendResponse(['message' => 'AskNicely API']);
        }
        break;
}
