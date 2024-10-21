<?php
session_start();
include "../util/database/DbHelper.php";

$db = new DbHelper();

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed', 'success' => false]);
    exit();
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$logFillables = ['username', 'password'];
$formData = [];
$errorMessages = [];

foreach ($logFillables as $log) {
    if (!isset($data[$log]) || empty(trim($data[$log]))) {
        $errorMessages[$log] = "$log is required";
    } else {
        $formData[$log] = $data[$log];
    }
}

if (!empty($errorMessages)) {
    http_response_code(422);
    echo json_encode($errorMessages);
    exit();
}

$admin = $db->fetchRecord('admin_info', ['username' => $formData['username']]);

if (empty($admin)) {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid Credentials']);
    exit();
}

if (password_verify($formData['password'], $admin['password'])) {
    http_response_code(204);
    $_SESSION['id'] = $admin['id'];
    exit();
} else {
    http_response_code(401);
    echo json_encode(['message' => 'Invalid Credentials']);
    exit();
}

