<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace AgParsedown;

use Parsedown;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array('namespaces' => array(
                __NAMESPACE__ => __DIR__ . '/src/',
            ))
        );
    }

    public function getViewHelperConfig()
    {
        return array('factories' => array(
            'parsedown' => function ($viewHelpers) {
                return new AgParsedown(new Parsedown);
            },
        ));
    }
}
