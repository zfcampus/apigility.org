<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController
{
    public function indexAction()
    {
    	$config = $this->getServiceLocator()->get('Config');

        return new ViewModel(array(
        	'version'  => $config['apigility']['version'],
        	'zip' => $config['links']['zip']
        ));
    }

    public function installAction()
    {
      $version = $this->params()->fromRoute('version');
      if (empty($version)) {
    	   $installer = file_get_contents(__DIR__ . '/../../../../../bin/install.php');
      } else {
         $installer = file_get_contents(__DIR__ . '/../../../../../bin/install.php.dist');
         $installer = str_replace('%VERSION%', $version, $installer);
      }

    	return $this->getResponse()->setContent($installer);
    }
}
