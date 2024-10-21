<?php

require_once "util/database/DbDrop.php";

$dbDrop = new DbDrop();

echo $dbDrop->drop();