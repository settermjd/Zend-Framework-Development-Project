<?php

class IndexController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $paginator = Zend_Paginator::factory(range(1, 50));
        $paginator->setCurrentPageNumber($this->_getParam('page', 1));
        $paginator->setView($this->view);
        $this->view->paginator = $paginator;
    }
    
}

