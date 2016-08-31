<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Documentation;

use Zend\ServiceManager\AbstractPluginManager;

class DocumentationControllerFactory
{
    public function __invoke($services)
    {
        if ($services instanceof AbstractPluginManager) {
            $services = $services->getServiceLocator() ?: $services;
        }
        return new DocumentationController($services->get('Documentation\Model'));
    }
}
