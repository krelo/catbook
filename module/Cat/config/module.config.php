<?php

namespace Cat;

use Zend\Router\Http\Segment;
use Zend\SErviceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'cat' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/cat[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\CatController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            'cat' => __DIR__ . '/../view',
        ],
    ],
];