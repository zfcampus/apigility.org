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

class DocumentationController extends AbstractActionController
{
	protected function getAside()
	{
		return array(
			'Getting started' => array(
				'Welcome' => $this->url()->fromRoute('doc'),
				'Installation' => $this->url()->fromRoute('doc/install')
			),
		);
	}
	
	public function indexAction()
    {   	
        return new ViewModel(array(
        	'aside'	=> $this->getAside(),
        	'current' => $this->url()->fromRoute('doc')
        ));
    }
    
    public function installAction()
    {
    	return new ViewModel(array(
        	'aside'	=> $this->getAside(),
        	'current' => $this->url()->fromRoute('doc/install')
        ));
    }
}
