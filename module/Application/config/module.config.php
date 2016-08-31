<?php
return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => 'Application\Controller\Home',
                        'action'     => 'index',
                    ],
                ],
            ],
            'install' => [
                'type' => 'segment',
                'options' => [
                    'route'    => '/install[/:version]',
                    'defaults' => [
                        'controller' => 'Application\Controller\Home',
                        'action'     => 'install'
                    ],
                    'constraints' => [
                        'version' => '[0-9]+\.[0-9]+\.[0-9]+'
                    ],
                ],
            ],
            'video' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/video',
                    'defaults' => [
                        'controller' => 'Application\Controller\Video',
                        'action'     => 'index',
                    ],
                ],
            ],
            'download' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/download',
                    'defaults' => [
                        'controller' => 'Application\Controller\Download',
                        'action'     => 'index',
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => [
                    'note' => [
                        'type' => 'literal',
                        'options' => [
                            'route' => '/note',
                            'defaults' => [
                                'controller' => 'Application\Controller\Download',
                                'action'     => 'note',
                            ],
                        ],
                    ],
                ],
            ],
            'contacts' => [
                'type' => 'literal',
                'options' => [
                    'route'    => '/contacts',
                    'defaults' => [
                        'controller' => 'Application\Controller\Contacts',
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'navigation' => [
         'default' => [
             [
                'label' => 'Home',
                'route' => 'home',
             ],
             [
                'label' => 'Video',
                'route' => 'video',
             ],
             [
                'label' => 'Documentation',
                'route' => 'documentation',
                'pages' => [
                    [
                        'label' => 'Manual',
                        'route' => 'documentation/page',
                    ],
                ],
             ],
             [
                'label' => 'Download',
                'route' => 'download',
                'pages' => [
                    [
                        'label' => 'Release note',
                        'route' => 'download/note',
                    ],
                ],
             ],
             [
                'label' => 'Contacts',
                'route' => 'contacts',
             ],
         ],
     ],
    'service_manager' => [
        'aliases' => [
            'translator' => 'MvcTranslator',
        ],
        'factories' => [
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ],
    ],
    'controllers' => [
        'invokables' => [
            'Application\Controller\Video' => 'Application\Controller\VideoController',
            'Application\Controller\Contacts' => 'Application\Controller\ContactsController',
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
    // Placeholder for console routes
    'console' => [
        'router' => [
            'routes' => [
            ],
        ],
    ],
];
