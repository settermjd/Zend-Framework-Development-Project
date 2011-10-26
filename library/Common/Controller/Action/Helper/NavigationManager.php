<?php

class Common_Controller_Action_Helper_NavigationManager
    extends Zend_Controller_Action_Helper_Abstract
{
    protected $_resources;

    public function preDispatch()
    {
        $bootstrap  = $this->getBootstrap();
        $controller = $this->getActionController();

        /*
         * Remove the business and codes navigation pages in all cases except
         * for displaying the user sitemap
         */
        if ($this->getRequest()->getActionName() != 'site-map') {
            $navigation = $bootstrap->getResource('navigation');

            // remove the codes page
            $codesPage = $navigation->findBy('id', 'codes');
            if ($codesPage) {
                $navigation->removePage($codesPage);
            }

            // remove the business pages
            $businessPage = $navigation->findBy('id', 'business-pages');
            if ($codesPage) {
                $navigation->removePage($businessPage);
            }
        }
    }

    public function getBootstrap()
    {
        return $this->getFrontController()->getParam('bootstrap');
    }
}