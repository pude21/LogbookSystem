<?php

include "../util/database/DbHelper.php";
require_once "../enums/Type.php";
require_once "../enums/Division.php";

$db = new DbHelper();
$types = Type::all();
$divisions = Division::all();

header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['message' => 'Method Not Allowed']);
    exit();
}

$json = file_get_contents('php://input');
$data = json_decode($json, true);

$visitor = ['type', 'fname', 'lname', 'office', 'division', 'purpose'];

$employee = ['type', 'employee_id', 'division', 'purpose'];

$employeeInfo = ['fname', 'lname', 'office'];

$errorMessages = [];
$fieldInput = [];

if (!isset($data['type']) || empty(trim($data['type']))) {
    http_response_code(422);
    $errorMessages['type'] = 'select a visitor type';
    echo json_encode(['message' => $errorMessages]);
    exit();
}

if (!in_array($data['type'], $types)) {
    http_response_code(422);
    $errorMessages['type'] = 'invalid type';
    echo json_encode(['message' => $errorMessages]);
    exit();
}

if ($data['type'] == 'Employee') {
    foreach ($employee as $e) {
        if (!isset($data[$e]) || empty(trim($data[$e]))) {
            $var = str_replace('_', ' ', $e);
            $errorMessages[$e] = "$var is required";
        } else {
            $fieldInput[$e] = $data[$e];
        }
    }

    if (!empty($errorMessages)) {
        http_response_code(422);
        echo json_encode(['message' => $errorMessages]);
        exit();
    }

    if (!in_array($fieldInput['division'], $divisions)) {
        $errorMessages['division'] = 'invalid division';
        $errorMessages['divisionRefetch'] = true;
        http_response_code(422);
        echo json_encode(['message' => $errorMessages]);
        exit();
    }

    require_once '../util/employeeData.php';
    $findEmployee = [];
    foreach ($employees as $e) {
        if ($e['empid'] == $fieldInput['employee_id']) {
            $findEmployee = $e;
        }
    }

    if (empty($findEmployee)) {
        $errorMessages['employee_id'] = 'employee not found';
        http_response_code(422);
        echo json_encode(['message' => $errorMessages]);
        exit();
    }

    foreach ($employeeInfo as $e) {
        if (!isset($data[$e]) || empty(trim($data[$e]))) {
            $var = str_replace('_', ' ', $e);
            $errorMessages[$e] = "$var is required";
        } else {
            $fieldInput[$e] = $data[$e];
        }
    }

    if (!empty($errorMessages)) {
        http_response_code(422);
        echo json_encode(['message' => $errorMessages]);
        exit();
    }

    $employeeLogged = $db->addRecord('visitor_info', $fieldInput);
    if ($employeeLogged > 0) {
        http_response_code(200);
        echo json_encode(['message' => 'Employee Logged Successfully']);
        exit();
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Error Logging Employee']);
        exit();
    }

} elseif ($data['type'] == 'Visitor') {
    foreach ($visitor as $v) {
        if (!isset($data[$v]) || empty(trim($data[$v]))) {
            $errorMessages[$v] = "$v is required";
        } else {
            $fieldInput[$v] = $data[$v];
        }
    }

    if (!empty($errorMessages)) {
        http_response_code(422);
        echo json_encode(['message' => $errorMessages]);
        exit();
    }

    if (!in_array($fieldInput['division'], $divisions)) {
        $errorMessages['division'] = 'invalid division';
        $errorMessages['divisionRefetch'] = true;
        http_response_code(422);
        echo json_encode(['message' => $errorMessages]);
        exit();
    }

    $visitorLogged = $db->addRecord('visitor_info', $fieldInput);
    if ($visitorLogged > 0) {
        http_response_code(200);
        echo json_encode(['message' => 'Visitor Logged Successfully']);
        exit();
    } else {
        http_response_code(400);
        echo json_encode(['message' => 'Error Logging Visitor']);
        exit();
    }
}