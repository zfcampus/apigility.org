<?php
/**
 * @link      http://github.com/zfcampus/apigility.org for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\AbstractPluginManager;

class Module
{
    public function onBootstrap(MvcEvent $e)
    {
        $serviceManager = $e->getApplication()->getServiceManager();
        $viewModel = $e->getApplication()->getMvcEvent()->getViewModel();
        $config = $serviceManager->get('config');
        $viewModel->forkme = $config['links']['forkme'];
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return ['factories' => [
            'Application\GithubReleases' => function ($services) {
                $releases = [];
                if (file_exists('data/releases.json')) {
                    $json     = file_get_contents('data/releases.json');
                    $releases = json_decode($json);
                }
                return new GithubReleases($releases);
            },
        ]];
    }

    public function getControllerConfig()
    {
        return ['factories' => [
            'Application\Controller\Download' => function ($services) {
                if ($services instanceof AbstractPluginManager) {
                    $services = $services->getServiceLocator() ?: $services;
                }
                return new Controller\DownloadController(
                    $services->get('Application\GithubReleases'),
                    $services->get('config')
                );
            },
            'Application\Controller\Home' => function ($services) {
                if ($services instanceof AbstractPluginManager) {
                    $services = $services->getServiceLocator() ?: $services;
                }
                return new Controller\HomeController(
                    $services->get('config')
                );
            },
        ]];
    }
}
