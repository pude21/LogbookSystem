<?php

require_once "util/database/DbSeeder.php";

$seeder = new DbSeeder('admin_info');

$admin_info = [
    'username' => 'admin_imnida',
    'password' => password_hash('123', PASSWORD_DEFAULT)
];

echo $seeder->seed($admin_info);