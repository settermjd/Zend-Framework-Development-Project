<?php

class BusinessController extends Zend_Controller_Action
{

    public function init()
    {
		$this->_helper->cache(array('index'), array('indexaction'));
		$this->view->layout = $this->_helper->layout;		
    }

    public function indexAction()
    {
        // action body
    }

    public function copyrightAction()
    {
        // action body
    }

    public function privacyAction()
    {
        // action body
    }

    public function termsConditionsAction()
    {
        // action body
    }

    public function disclaimerAction()
    {
        // action body
    }

    public function sitemapAction()
    {
        // action body
    }

    public function aboutAction()
    {
        // action body
    }

    public function securityAction()
    {
        // action body
    }


}



