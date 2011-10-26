<?php

class Common_Application_Resource_Services extends Zend_Application_Resource_ResourceAbstract
{
    protected $_map = array();

    public function init()
    {
        return $this->getServiceConfig();
    }

    protected function getServiceConfig()
    {
        // get the resource options
        $options = $this->getOptions();

        foreach ($options['service'] as $serviceName => $serviceOptions) {
            if (array_key_exists('enabled', $serviceOptions)) {
                if (!$serviceOptions['enabled']) { continue; }
            }
            $this->_map[$serviceName] = Common_Services_Factory::factory($serviceName, $serviceOptions);
        }

        return $this->_map;
    }
}