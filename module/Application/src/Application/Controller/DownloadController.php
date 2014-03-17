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

class DownloadController extends AbstractActionController
{	
	protected function getAside()
	{
		return array(
			'' => array(
				'Download' => $this->url()->fromRoute('download'),
				'Changelog' => $this->url()->fromRoute('download/note')
			),
			'Previous Releases' => array(
				'0.9.0' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/tag/0.9.0',
				'0.8.0' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/tag/0.8.0',
				'0.7.0' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/tag/0.7.0',
				'0.6.0' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases/tag/0.6.0',
				'All the releases' => 'https://github.com/zfcampus/zf-apigility-skeleton/releases'
			)
		);
	}
	
    public function indexAction()
    {   	
        $config = $this->getServiceLocator()->get('Config');
    	
        return new ViewModel(array(
        	'aside'   => $this->getAside(),
        	'current' => $this->url()->fromRoute('download'),
        	'version' => $config['apigility']['version'],
        	'tgz'     => $config['links']['tgz'],
        	'zip'     => $config['links']['zip']
        ));
    }
    
    public function noteAction()
    {
    	$config = $this->getServiceLocator()->get('Config');
    	 
    	return new ViewModel(array(
    		'aside' => $this->getAside(),
    		'current' => $this->url()->fromRoute('download/note'),
    		'version' => $config['apigility']['version']
    	));
    }
}
