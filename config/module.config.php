<?php declare(strict_types=1);
namespace Diva;

return [
    'view_manager' => [
        'template_path_stack' => [
            dirname(__DIR__) . '/view',
        ],
    ],
    'view_helpers' => [
        'factories' => [
            'diva' => Service\ViewHelper\DivaFactory::class,
        ],
    ],
    'block_layouts' => [
        'invokables' => [
            'diva' => Site\BlockLayout\Diva::class,
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Diva\Controller\Player' => Controller\PlayerController::class,
        ],
        // The aliases simplify the routing, the url assembly and allows to support module Clean url.
        'aliases' => [
            'Diva\Controller\Item' => Controller\PlayerController::class,
            'Diva\Controller\CleanUrlController' => Controller\PlayerController::class,
        ],
    ],
    'router' => [
        'routes' => [
            'site' => [
                'child_routes' => [
                    // This route allows to have a url compatible with Clean url.
                    'resource-id' => [
                        'may_terminate' => true,
                        'child_routes' => [
                            'diva' => [
                                'type' => \Laminas\Router\Http\Literal::class,
                                'options' => [
                                    'route' => '/diva',
                                    'constraints' => [
                                        'controller' => 'item',
                                        'action' => 'play',
                                    ],
                                    'defaults' => [
                                        '__NAMESPACE__' => 'Diva\Controller',
                                        'controller' => 'Player',
                                        'action' => 'play',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    // This route is the default url.
                    'resource-id-diva' => [
                        'type' => \Laminas\Router\Http\Segment::class,
                        'options' => [
                            'route' => '/:controller/:id/diva',
                            'constraints' => [
                                'controller' => 'item',
                                'action' => 'play',
                            ],
                            'defaults' => [
                                '__NAMESPACE__' => 'Diva\Controller',
                                'controller' => 'Player',
                                'action' => 'play',
                                'id' => '\d+',
                            ],
                        ],
                    ],
                ],
            ],
            // This route allows to have a top url without Clean url.
            // TODO Remove this route?
            'diva_player' => [
                'type' => \Laminas\Router\Http\Segment::class,
                'options' => [
                    'route' => '/:controller/:id/diva',
                    'constraints' => [
                        'controller' => 'item',
                        'id' => '\d+',
                    ],
                    'defaults' => [
                        '__NAMESPACE__' => 'Diva\Controller',
                        // '__SITE__' => true,
                        'controller' => 'Player',
                        'action' => 'play',
                    ],
                ],
            ],
        ],
    ],
    'translator' => [
        'translation_file_patterns' => [
            [
                'type' => 'gettext',
                'base_dir' => dirname(__DIR__) . '/language',
                'pattern' => '%s.mo',
                'text_domain' => null,
            ],
        ],
    ],
    'diva' => [
    ],
];
