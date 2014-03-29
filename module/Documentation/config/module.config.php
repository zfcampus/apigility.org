<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

return array(
    'controllers' => array(
        'factories' => array(
            'Documentation\Controller' => 'Documentation\DocumentationControllerFactory',
        ),
    ),
    'router' => array('routes' => array(
        'documentation' => array(
            'type' => 'Literal',
            'options' => array(
                'route' => '/ag-documentation',
                'defaults' => array(
                    'controller' => 'Documentation\Controller',
                    'action'     => 'index',
                ),
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'page' => array(
                    'type' => 'Segment',
                    'options' => array(
                        'route' => '/:page',
                        'defaults' => array(
                            'action' => 'page',
                        ),
                        'constraints' => array(
                            'page' => '[a-zA-Z0-9][a-zA-Z0-9_./-]*',
                        ),
                    ),
                ),
            ),
        ),
    )),
    'service_manager' => array(
        'factories' => array(
            'Documentation\Model' => 'Documentation\DocumentationModelFactory',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
