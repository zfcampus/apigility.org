<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Documentation;

class PygmentizeFactory
{
    public function __invoke($services)
    {
        $path = '/usr/bin/pygmentize';
        if ($services->has('Config')) {
            $path = $this->getPathFromConfig($path, $services->get('Config'));
        }
        return new Pygmentize($path);
    }

    public function getPathFromConfig($path, array $config)
    {
        if (! isset($config['pygmentize'])) {
            return $path;
        }

        if (! file_exists($config['pygmentize'])) {
            return $path;
        }

        return $config['pygmentize'];
    }
}
