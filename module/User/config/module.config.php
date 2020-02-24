<?php

namespace Cat;

use Zend\Router\Http\Segment;
use Zend\SErviceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
    
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'user' => __DIR__ . '/../view',
        ],
    ],
];