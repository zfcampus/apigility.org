<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Application\GithubReleases;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DownloadController extends AbstractActionController
{	
    /**
     * @var GithubReleases
     */
    protected $releases;

    public function __construct(GithubReleases $releases)
    {
        $this->releases = $releases;
    }

	protected function getAside()
	{
		$aside = array(
			'' => array(
				'Download' => $this->url()->fromRoute('download'),
				'Changelog' => $this->url()->fromRoute('download/note')
			),
            'Previous Releases' => array(),
        );
        foreach ($this->releases as $release) {
            $aside['Previous Releases'][$release['tag']] = $release['url'];
        }
        $aside['Previous Releases']['All the releases'] = 'https://github.com/zfcampus/zf-apigility-skeleton/releases';
        return $aside;
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
    	$config    = $this->getServiceLocator()->get('Config');
        $version   = $config['apigility']['version'];
        $changelog = 'No changelog found';

        foreach ($this->releases as $release) {
            if ($release['tag'] === $version) {
                $changelog = $release['notes'];
                break;
            }
        }
    	 
    	return new ViewModel(array(
    		'aside'     => $this->getAside(),
    		'current'   => $this->url()->fromRoute('download/note'),
    		'version'   => $version,
            'changelog' => $changelog,
    	));
    }
}
