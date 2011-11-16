<?php

class MaltBlue_Application_Resource_Placeholder extends Zend_Application_Resource_ResourceAbstract
{
    protected $_placeholders;
    
    protected $_view;
 
    public function init()
    {
        $this->_initPlaceholders();
    }
 
    protected function _initPlaceholders()
    {
        $options = $this->getOptions();
        
        if (!empty($options)) {
            // ensure view is initialized...
            $this->getBootstrap()->bootstrap('view');

            // Get view object:
            $view = $this->getBootstrap()->getResource('view');
            
            foreach ($options as $placeholderName => $placeholderConfig) {
                foreach ($placeholderConfig as $key => $value) {
                    $view->placeholder($placeholderName)->$key = $value;
                }
            }
        }

        return $this->_view;
    }
}