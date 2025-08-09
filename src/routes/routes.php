<?php

use Controller\Taskcontroller;

return [
    '~^$~' => [
        'controller' => Taskcontroller::class,
        'methods' => [
            'GET' => 'render'
        ]
    ],
    '~^tasks$~' => [
        'controller' => Taskcontroller::class,
        'methods' => [
            'GET' => 'getAllTasks',
            'POST' => 'addTask',
            'PUT' => 'updateTask',
            ]
    ],
    '~^tasks/(\d+)$~' => [
        'controller' => Taskcontroller::class,
        'methods' => [
            'GET' => 'getTask',
            'DELETE' => 'deleteTask',
            ]
    ],
];
