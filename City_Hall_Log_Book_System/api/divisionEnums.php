<?php

require_once "../enums/Division.php";

$divisions = Division::all();

header("Content-Type: application/json");

echo json_encode($divisions);