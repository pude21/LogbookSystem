<?php
session_start();

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed', 'success' => false]);
    exit();
}

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized Access']);
    exit();
}

http_response_code(204);
session_destroy();
session_unset();

