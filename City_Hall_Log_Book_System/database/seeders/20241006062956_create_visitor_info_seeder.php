<?php

require_once "util/database/DbSeeder.php";

$seeder = new DbSeeder('visitor_info');

$visitors = [
    [
        'fname' => 'Taylor',
        'lname' => 'Swift',
        'purpose' => 'Visit the Cebu City Medical Center',
        'office' => 'Cebu City Medical Center',
        'division' => 'Administrative',
        'type' => 'Visitor'
    ],
    [
        'fname' => 'Ariana',
        'lname' => 'Grande',
        'purpose' => 'Meet with the Mayor',
        'office' => 'Office of the Mayor',
        'division' => 'Client Support',
        'type' => 'Visitor'
    ],
    [
        'fname' => 'Olivia',
        'lname' => 'Rodrigo',
        'purpose' => 'Attend a meeting',
        'office' => 'Cebu City Environment and Natural Resources Office',
        'division' => 'Technical Support',
        'type' => 'Visitor'
    ],
    [
        'fname' => 'Justin',
        'lname' => 'Bieber',
        'purpose' => 'Visit the City Health Department',
        'office' => 'City Health Department',
        'division' => 'Developers',
        'type' => 'Visitor'
    ],
    [
        'fname' => 'Lady',
        'lname' => 'Gaga',
        'purpose' => 'Inspect the facilities',
        'office' => 'Peace and Order Program',
        'division' => 'Administrative',
        'type' => 'Visitor'
    ]
];

$employees = [
    [
        'employee_id' => '29381',
        'fname' => 'Nicki',
        'lname' => 'Minaj',
        'purpose' => 'Work at the Office of the City Accountant',
        'office' => 'Office of the City Accountant',
        'division' => 'Administrative',
        'type' => 'Employee'
    ],
    [
        'employee_id' => '12345',
        'fname' => 'Katy',
        'lname' => 'Perry',
        'purpose' => 'Work at the Cebu City Medical Center',
        'office' => 'Cebu City Medical Center',
        'division' => 'Client Support',
        'type' => 'Employee'
    ],
    [
        'employee_id' => '67890',
        'fname' => 'Beyoncé',
        'lname' => 'Knowles-Carter',
        'purpose' => 'Work at the Cebu City Environment and Natural Resources Office',
        'office' => 'Cebu City Environment and Natural Resources Office',
        'division' => 'Technical Support',
        'type' => 'Employee'
    ],
    [
        'employee_id' => '11111',
        'fname' => 'Rihanna',
        'lname' => 'Fenty',
        'purpose' => 'Work at the City Health Department',
        'office' => 'City Health Department',
        'division' => 'Developers',
        'type' => 'Employee'
    ],
    [
        'employee_id' => '22222',
        'fname' => 'Abel',
        'lname' => 'Tesfaye',
        'purpose' => 'Work at the Peace and Order Program',
        'office' => 'Peace and Order Program',
        'division' => 'Administrative',
        'type' => 'Employee'
    ]
];

$visitor_info = array_merge($visitors, $employees);

// echo $seeder->seed($visitor_info, true);