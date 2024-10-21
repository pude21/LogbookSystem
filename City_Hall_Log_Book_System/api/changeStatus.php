<?php
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized Access']);
    exit();
}
include "../util/database/DbHelper.php";
include "../enums/Status.php";

$db = new DbHelper();
$statuses = Status::all();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed', 'success' => false]);
    exit();
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$id = isset($data['id']) ? $data['id'] : '';
$status = isset($data['status']) ? $data['status'] : '';

if (empty($id) || empty($status)) {
    echo json_encode(['message' => 'Fill out the missing fields', 'success' => false]);
    exit();
}

if (!in_array($status, $statuses)) {
    http_response_code(404);
    echo json_encode(['message' => 'Incorrect Status', 'success' => false]);
    exit();
}

$updateStatus = $db->updateRecord('visitor_info', ['id' => $id, 'status' => $status]);

if ($updateStatus > 0) {
    echo json_encode(['message' => 'Status Updated Successfully', 'success' => true]);
} else {
    echo json_encode(['message' => 'Error Updating Status', 'success' => false]);
}