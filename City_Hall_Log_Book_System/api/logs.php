<?php
session_start();

header("Content-Type: application/json");

if (!isset($_SESSION['id'])) {
    http_response_code(401);
    echo json_encode(['message' => 'Unauthorized Access']);
    exit();
}
include "../util/database/DbHelper.php";

$db = new DbHelper();

echo json_encode($db->getAllLogs());