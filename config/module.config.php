<?php
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
    ],
    'form_elements' => [
        'invokables' => [
            Form\ConfigForm::class => Form\ConfigForm::class,
        ],
        'factories' => [
            Form\SiteSettingsFieldset::class => Service\Form\SiteSettingsFieldsetFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'diva_player' => [
                'type' => \Zend\Router\Http\Segment::class,
                'options' => [
                    'route' => '/:resourcename/:id/diva',
                    'constraints' => [
                        'resourcename' => 'item|item\-set',
                        'id' => '\d+',
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
        'config' => [
            'diva_manifest_property' => '',
        ],
        'site_settings' => [
            'diva_append_item_set_show' => true,
            'diva_append_item_show' => true,
            'diva_append_item_set_browse' => false,
            'diva_append_item_browse' => false,
            'diva_class' => '',
            'diva_style' => 'display: block; width: 90%; height: 600px; margin: 1em 5%; position: relative;',
            'diva_locale' => 'en',
        ],
    ],
];
