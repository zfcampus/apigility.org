<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(
    'router' => array(
        'routes' => array(
            'home' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'Application\Controller\Home',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'install' => array(
        		'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route'    => '/install',
        			'defaults' => array(
        				'controller' => 'Application\Controller\Home',
        				'action'     => 'install',
        			),
        		),
        	),
        	'video' => array(
        		'type' => 'Zend\Mvc\Router\Http\Literal',
        		'options' => array(
        			'route'    => '/video',
        			'defaults' => array(
        				'controller' => 'Application\Controller\Video',
        				'action'     => 'index',
        			),
        		),
        	),
        	'doc' => array(
        			'type' => 'Zend\Mvc\Router\Http\Literal',
        			'options' => array(
        					'route'    => '/documentation',
        					'defaults' => array(
        							'controller' => 'Application\Controller\Documentation',
        							'action'     => 'index',
        					),
        			),
        			'may_terminate' => true,
        			'child_routes' => array(
        					'install' => array(
        							'type' => 'Zend\Mvc\Router\Http\Literal',
        							'options' => array(
        									'route' => '/install',
        									'defaults' => array(
        											'controller' => 'Application\Controller\Documentation',
        											'action'     => 'install',
        									),
        							),
        					),
        			),
        	),
        	'download' => array(
        			'type' => 'Zend\Mvc\Router\Http\Literal',
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
        							'type' => 'Zend\Mvc\Router\Http\Literal',
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
        			'type' => 'Zend\Mvc\Router\Http\Literal',
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
             		'route' => 'doc',
             		'pages' => array(
             				array(
             						'label' => 'Installation',
             						'route' => 'doc/install'
             				)
             		)
             ),
             array(
             		'label' => 'Download',
             		'route' => 'download',
             		'pages' => array(
             			array(
             				'label' => 'Release note',
             				'route' => 'download/note'
             			)
             		)
             ),
             array(
             		'label' => 'Contacts',
             		'route' => 'contacts',
             ),
         ),
     ),
    'service_manager' => array(
        'abstract_factories' => array(
            'Zend\Cache\Service\StorageCacheAbstractServiceFactory',
            'Zend\Log\LoggerAbstractServiceFactory',
        ),
        'aliases' => array(
            'translator' => 'MvcTranslator',
        ),
        'factories' => array(
        	'navigation' => 'Zend\Navigation\Service\DefaultNavigationFactory',
        ),
    ),
    'translator' => array(
        'locale' => 'en_US',
        'translation_file_patterns' => array(
            array(
                'type'     => 'gettext',
                'base_dir' => __DIR__ . '/../language',
                'pattern'  => '%s.mo',
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'Application\Controller\Home' => 'Application\Controller\HomeController',
            'Application\Controller\Video' => 'Application\Controller\VideoController',
            'Application\Controller\Download' => 'Application\Controller\DownloadController',
            'Application\Controller\Contacts' => 'Application\Controller\ContactsController',
            'Application\Controller\Documentation' => 'Application\Controller\DocumentationController'
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
