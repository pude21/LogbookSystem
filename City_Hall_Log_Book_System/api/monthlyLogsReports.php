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

if (!isset($_GET['month'])) {
    http_response_code(404);
    echo json_encode('Input the month');
    exit();
}
$month = $_GET['month'];

$visitor_count = $db->allClients($month);

echo json_encode($visitor_count);
