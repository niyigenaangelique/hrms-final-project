<?php

return [
    'passwords'=>[
        'super_admin' => env('DEFAULT_SUPER_ADMIN_PASSWORD', 'ChangeMe@123'),
        'admin' => env('DEFAULT_ADMIN_PASSWORD', 'ChangeMe@123'),
        'default' => env('DEFAULT_PASSWORD', 'ChangeMe@123'),
        'manager' => env('DEFAULT_MANAGER_PASSWORD', 'ChangeMe@123'),
        'officer' => env('DEFAULT_OFFICER_PASSWORD', 'ChangeMe@123'),
        'supervisor' => env('DEFAULT_SUPERVISOR_PASSWORD', 'ChangeMe@123'),
        'employee' => env('DEFAULT_EMPLOYEE_PASSWORD', 'ChangeMe@123'),

    ]
];
