<?php

class MaltBlue_Application_Resource_Paginator extends Zend_Application_Resource_ResourceAbstract
{
    const DEFAULT_SCROLLING_TYPE = 'Sliding';
    
    const DEFAULT_RECORDS_PER_PAGE = 10;
    
    const PAGINATOR_CACHE = 'paginator';
    
    public function init()
    {
        $this->_initPaginator();
    }
 
    protected function _initPaginator()
    {
        $options = $this->getOptions();
        
        if (array_key_exists('cache', $options) && $options['cache']) {
            // ensure the cache is initialized...
            $this->getBootstrap()->bootstrap('cachemanager');
            
            // get the cache manager object
            $manager = $this->getBootstrap()->getResource('cachemanager');
            
            // get the paginator cache object
            $cache = $manager->getCache(self::PAGINATOR_CACHE);
            
            if (!is_null($cache)) {
            	Zend_Paginator::setCache($cache);
            }
        }
        
        if (!empty($options['scrollingType'])) {
            Zend_Paginator::setDefaultScrollingStyle(
                $options['scrollingType']
            );
        } else {
            Zend_Paginator::setDefaultScrollingStyle(
                self::DEFAULT_SCROLLING_TYPE
            );
        }
        
        if (!empty($options['recordsPerPage'])) {
            Zend_Paginator::setDefaultItemCountPerPage(
                $options['recordsPerPage']
            );
        } else {
            Zend_Paginator::setDefaultItemCountPerPage(
                self::DEFAULT_RECORDS_PER_PAGE
            );
        }
        
        if (!empty($options['viewScript'])) {
            Zend_View_Helper_PaginationControl::setDefaultViewPartial(
                $options['viewScript']
            );
        }
    }
}