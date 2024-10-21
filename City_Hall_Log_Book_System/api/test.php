<?php

include "../util/database/DbHelper.php";

$db = new DbHelper();

header("Content-Type: application/json");

echo json_encode($db->getCurrentDate());