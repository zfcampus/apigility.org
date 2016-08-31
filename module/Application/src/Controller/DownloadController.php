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
     * @var array
     */
    private $config;

    /**
     * @var GithubReleases
     */
    protected $releases;

    public function __construct(GithubReleases $releases, array $config)
    {
        $this->releases = $releases;
        $this->config = $config;
    }

    protected function getAside()
    {
        $aside = [
            '' => [
                'Download' => $this->url()->fromRoute('download'),
                'Changelog' => $this->url()->fromRoute('download/note')
            ],
            'Previous Releases' => [],
        ];
        foreach ($this->releases as $release) {
            $aside['Previous Releases'][$release['tag']] = $release['url'];
        }
        $aside['Previous Releases']['All the releases'] = 'https://github.com/zfcampus/zf-apigility-skeleton/releases';
        return $aside;
    }

    public function indexAction()
    {
        return new ViewModel([
            'aside'   => $this->getAside(),
            'current' => $this->url()->fromRoute('download'),
            'version' => $this->config['apigility']['version'],
            'tgz'     => $this->config['links']['tgz'],
            'zip'     => $this->config['links']['zip']
        ]);
    }

    public function noteAction()
    {
        $version   = $this->config['apigility']['version'];
        $changelog = 'No changelog found';

        foreach ($this->releases as $release) {
            if ($release['tag'] === $version) {
                $changelog = $release['notes'];
                break;
            }
        }

        return new ViewModel([
            'aside'     => $this->getAside(),
            'current'   => $this->url()->fromRoute('download/note'),
            'version'   => $version,
            'changelog' => $changelog,
        ]);
    }
}
