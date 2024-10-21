<?php

require_once "../enums/Type.php";

$types = Type::all();

header("Content-Type: application/json");

echo json_encode($types);