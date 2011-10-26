<?php

class Common_Util_Logger
{
    static public function writeLog($message, $priority)
    {
        if (empty($message) || empty($priority)) {
            return FALSE;
        }
        $bootstrap = Zend_Controller_Front::getInstance()->getParam('bootstrap');
        if ($bootstrap instanceof Zend_Controller_Front) {
            return FALSE;
        }
        $logger = $bootstrap->getResource('log');
        $logger->log($message, $priority);
    }
}