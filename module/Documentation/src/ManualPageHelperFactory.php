<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Documentation;

class ManualPageHelperFactory
{
    public function __invoke($helpers)
    {
        $services = $helpers->getServiceLocator();
        return new ManualPageHelper(
            $helpers->get('parsedown'),
            $helpers->get('url'),
            $services->get('Documentation\Pygmentize')
        );
    }
}
