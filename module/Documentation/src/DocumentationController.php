<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace Documentation;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class DocumentationController extends AbstractActionController
{
    /**
     * @var DocumentationModel
     */
    protected $model;

    public function __construct(DocumentationModel $model)
    {
        $this->model = $model;
    }

    public function indexAction()
    {
        $view = new ViewModel(array(
            'model' => $this->model,
        ));
        $view->setTemplate('documentation/index');
        return $view;
    }

    public function pageAction()
    {
        $page = $this->getEvent()->getRouteMatch()->getParam('page', false);
        if (! $page || ! $this->model->hasPage($page)) {
            $response = $this->getResponse();
            $response->setStatusCode(404);
            $view = new ViewModel();
            $view->setTemplate('error/404');
            return $view;
        }

        $view = new ViewModel(array(
            'model' => $this->model,
            'page'  => $page,
        ));
        $view->setTemplate('documentation/page');
        return $view;
    }
}
