<?php
return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Home',
                        'action'     => 'index',
                    ),
                ),
            ),
            'install' => array(
                'type' => 'segment',
                'options' => array(
                    'route'    => '/install[/:version]',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Home',
                        'action'     => 'install'
                    ),
                    'constraints' => array(
                        'version' => '[0-9]+\.[0-9]+\.[0-9]+'
                    ),
                ),
            ),
            'video' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/video',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Video',
                        'action'     => 'index',
                    ),
                ),
            ),
            'download' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/download',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Download',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'note' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/note',
                            'defaults' => array(
                                'controller' => 'Application\Controller\Download',
                                'action'     => 'note',
                            ),
                        ),
                    ),
                ),
            ),
            'contacts' => array(
                'type' => 'literal',
                'options' => array(
                    'route'    => '/contacts',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Contacts',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
    'navigation' => array(
         'default' => array(
             array(
                'label' => 'Home',
                'route' => 'home',
             ),
             array(
                'label' => 'Video',
                'route' => 'video',
             ),
             array(
                'label' => 'Documentation',
                'route' => 'documentation',
                'pages' => array(
                    array(
                        'label' => 'Manual',
                        'route' => 'documentation/page',
                    ),
                ),
             ),
             array(
                'label' => 'Download',
                'route' => 'download',
                'pages' => array(
                    array(
                        'label' => 'Release note',
                        'route' => 'download/note',
                    ),
                ),
             ),
             array(
                'label' => 'Contacts',
                'route' => 'contacts',
             ),
         ),
     ),
    'service_manager' => array(
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
            'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Video' => 'Application\Controller\VideoController',
            'Application\Controller\Contacts' => 'Application\Controller\ContactsController',
        ),
    ),
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
