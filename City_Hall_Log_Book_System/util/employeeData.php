<?php

$url = 'https://www.cebucity.gov.ph/pitchV2/employees.php/employees';

header("Content-Type: application/json");

$context = stream_context_create([
    'ssl' => [
        'verify_peer' => false,
        'verify_peer_name' => false,
    ],
]);

try {
    $response = @file_get_contents($url, false, $context);
    if ($response === false) {
        throw new Exception("We're having trouble connecting to the server. Please try again later.");
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
    exit();
}

$employee = json_decode($response, true, 512, JSON_OBJECT_AS_ARRAY);
$employees = $employee['employees'];
