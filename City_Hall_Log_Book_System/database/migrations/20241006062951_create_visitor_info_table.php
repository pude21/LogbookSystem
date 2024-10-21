<?php

require_once "enums/Division.php";
require_once "enums/Status.php";
require_once "enums/Type.php";
require_once "util/database/DbMigration.php";

$migration = new DbMigration('visitor_info');

$division = implode("', '", Division::all());
$types = implode("', '", Type::all());
$status = implode("', '", Status::all());

$migration->addColumn('id', 'int', false, null, true)
    ->addColumn('employee_id', 'varchar(100)', true)
    ->addColumn('fname', 'varchar(100)')
    ->addColumn('lname', 'varchar(100)')
    ->addColumn('purpose', 'varchar(100)')
    ->addColumn('office', 'varchar(100)')
    ->addColumn('division', "enum('$division')", false, Division::Technical_Support->value)
    ->addColumn('type', "enum('$types')", false, Type::Visitor->value)
    ->addColumn('status', "enum('$status')", false, Status::Pending->value)
    ->addColumn('date', "timestamp", false, 'CURRENT_TIMESTAMP')
    ->addPrimaryKey('id');

echo $migration->create();