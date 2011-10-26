<?php

class Common_Controller_Action_Helper_ResourceInjector
    extends Zend_Controller_Action_Helper_Abstract
{
    protected $_resources;

    public function preDispatch()
    {
        $bootstrap  = $this->getBootstrap();
        $controller = $this->getActionController();

        if (!isset($controller->dependencies) || !is_array($controller->dependencies)) {
            return;
        }

        foreach ($controller->dependencies as $name) {
            if ($bootstrap->hasResource($name)) {
                $controller->$name = $bootstrap->getResource($name);
            }
        }
    }

    public function getBootstrap()
    {
        return $this->getFrontController()->getParam('bootstrap');
    }
}