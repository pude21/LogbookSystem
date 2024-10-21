<?php

$filePath1 = 'util/Misc.php';
$filePath2 = '../util/Misc.php';

if (file_exists($filePath1)) {
    require_once $filePath1;
} elseif (file_exists($filePath2)) {
    require_once $filePath2;
} else {
    die("Error: File does not exist in both directories.");
}

enum Status: string
{
    case Pending = 'Pending';
    case Accepted = 'Accepted';
    case Cancelled = 'Cancelled';

    public static function all()
    {
        return Misc::displayEnums(self::cases());
    }
}