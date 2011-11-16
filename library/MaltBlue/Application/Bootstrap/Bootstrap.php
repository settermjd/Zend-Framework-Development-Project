<?php

class MaltBlue_Application_Bootstrap_Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /**
     * @var int
     */
    const DEFAULT_RECORDS_PER_PAGE = 10;
    
    const CACHE_KEY_NAVIGATION = 'nav_config';
    
    const CACHE_KEY_ACL = 'app_acl';
    
    const CACHE_KEY_VIEW = 'app_view';
    
    const CACHE_KEY_ROUTE = 'app_routes';

    /**
     * A bootstrap resource to make possible caching of application routes
     */
    protected function _initRoutes() 
    {
        $this->bootstrap('frontcontroller');
        $front = Zend_Controller_Front::getInstance();
        $router = $front->getRouter();
        $routeIniFile = APPLICATION_PATH . '/configs/routes.ini';
        $routeCache = 'routesConfig';

        // get the routes cache manager object
        $cacheManager = $this->bootstrap('cachemanager')->getResource('cachemanager');

        if ($cacheManager->hasCache($routeCache)) {
            // attempt to load the routes config from cache
            $cache = $cacheManager->getCache($routeCache);
            if (!is_null($cacheManager) && !is_null($cache)) {
                $routesConfig = $cache->load(self::CACHE_KEY_ROUTE);
            }
        }
        
        // unable to get a cached copy - manually loading it
        if (empty($routesConfig)) {
            $routesConfig = new Zend_Config_Ini($routeIniFile, APPLICATION_ENV);
            $cache->save($routesConfig, self::CACHE_KEY_ROUTE);
        }
        
        $router->addConfig($routesConfig, 'routes');
    }

    /**
     *  Instantiate the application database resource object
     *
     *  @return Zend_Db_Adapter
     *  @link http://framework.zend.com/manual/en/zend.db.html
     */
    protected function _initDb()
    {
        // Only attempt to cache the metadata if we have a cache available
        if (!is_null($this->_cache)) {
            try {
                Zend_Db_Table_Abstract::setDefaultMetadataCache($this->_cache);
            } catch(Zend_Db_Table_Exception $e) {
                print $e->getMessage();
            }
        }
        
        $db = null;
        $dbPluginResource = $this->getPluginResource('db');
        
        if (!is_null($dbPluginResource)) {
            $db = $dbPluginResource->getDbAdapter();

            // Set the default fetch mode to object throughout the application
            $db->setFetchMode(Zend_Db::FETCH_OBJ);

            // Force the initial connection to handle error relating to caching etc.         
            try {
                $db->getConnection();
            } catch (Zend_Db_Adapter_Exception $e) {
                // perhaps a failed login credential, or perhaps the RDBMS is not running
            } catch (Zend_Exception $e) {
                // perhaps factory() failed to load the specified Adapter class
            }
            Zend_Db_Table::setDefaultAdapter($db);
            Zend_Registry::set('db', $db);
        }
        
        return $db;
    }

    protected function _initView()
    {
        $resources = $this->getOption('resources');
        $options = array();
        
        if (isset($resources['view'])) { 
            $options = $resources['view']; 
        }
        
        $this->bootstrap('cache');
        $cache = $this->getResource('cache');
        
        if (!is_null($cache)) {
            if (($view = $cache->load(self::CACHE_KEY_VIEW)) === false) {
                $view = new Common_View($options);
                $cache->save($view, self::CACHE_KEY_VIEW);
            } 
        } else {
            $view = new Common_View($options);
        }
        
        if (isset($options['doctype'])) {
            $view->doctype()->setDoctype(strtoupper($options['doctype']));
            if (isset($options['charset']) && $view->doctype()->isHtml5()) {
                $view->headMeta()->setCharset($options['charset']);
            }
        }
        if (isset($options['contentType'])) {
            $view->headMeta()->appendHttpEquiv('Content-Type', $options['contentType']);
        }
        $viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
        $viewRenderer->setView($view);
        Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);
        return $view;
    }
  
    /**
     * Setup the application navigation.
     *
     * Covers support for menus, links, breadcrumbs and is translation enabled
     * @link http://framework.zend.com/manual/en/zend.navigation.html
     * @see _buildNavigationObject()
     */
    protected function _initNavigation()
    {
        $this->bootstrap('cache');
        $cache = $this->getResource('cache');

        // load it from cache if possible.
        if (!is_null($cache)) {
            if (($navigation = $cache->load(self::CACHE_KEY_NAVIGATION)) === false) {
                $navigation = $this->_buildNavigationList();
                $cache->save($navigation, self::CACHE_KEY_NAVIGATION);
            }
        } else {
            $navigation = $this->_buildNavigationList();
        }
        
        Zend_Registry::set('Zend_Navigation', $navigation);
        return $navigation;
    }
    
    protected function _buildNavigationList()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');
        $view = $layout->getView();
        $config = new Zend_Config_Xml(APPLICATION_PATH . '/configs/navigation.xml', 'nav');
        $navigation = new Zend_Navigation($config);
        $view->navigation($navigation);
        return $navigation;
    }
    
    protected function getConfig($option) 
    {
        return (object)$this->getOption($option);
    } 
    
    /**
     * Setup the application cache.
     *
     * @return Zend_Cache
     * @link http://framework.zend.com/manual/en/zend.cache.html
     */
    protected function _initCache()
    {
        $this->bootstrap('Config');
        $appConfig = Zend_Registry::get('config');
        $cache = NULL;

        // only attempt to init the cache if turned on
        if ($appConfig->app->caching) {
            // get the cache settings
            $config = $appConfig->app->cache;

            try {
                $cache = Zend_Cache::factory(
                        $config->frontend->adapter,
                        $config->backend->adapter,
                        $config->frontend->options->toArray()
                );
            } catch (Zend_Cache_Exception $e) {
                // ...
            }
        }
        Zend_Registry::set('cache', $cache);
        return $cache;
    }

    /**
     * Setup the core config resource
     *
     * @return Zend_Config_Ini
     * @link http://framework.zend.com/manual/en/zend.config.html
     */
    protected function _initConfig()
    {
        $config = new Zend_Config_Ini(
            APPLICATION_PATH . "/configs/application.ini",
            $this->getEnvironment()
        );
        Zend_Registry::set('config', $config);
        
        return $config;
    } 
    
    /**
     * Sets up the ZF Debug plugin.
     *
     * This displays a bar that gives debug statistics about the application
     * @see http://code.google.com/p/zfdebug/
     * @link http://code.google.com/p/zfdebug/wiki/Documentation
     */
/*    protected function _initZFDebug()
    {
        $autoloader = Zend_Loader_Autoloader::getInstance();
        $autoloader->registerNamespace('ZFDebug');

        $options = array(
            'plugins' => array('Variables',
                               'File' => array('base_path' => APPLICATION_PATH),
                               'Html',
                               'Memory',
                               'Time',
                               'Registry',
                               'Exception'),
            'z-index' => 255,
            'image_path' => '/images/debugbar',
            'jquery_path' => 'http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js',
        );

        // Instantiate the database adapter and setup the plugin.
        // Alternatively just add the plugin like above and rely on the autodiscovery feature.
        if ($this->hasPluginResource('Db')) {
            $this->bootstrap('Db');
            $db = $this->getPluginResource('Db')->getDbAdapter();
            $options['plugins']['Database']['adapter'] = $db;
        }

        // Setup the cache plugin
        if ($this->hasPluginResource('Cache')) {
            $this->bootstrap('Cache');
            $cache = $this-getPluginResource('Cache')->getDbAdapter();
            $options['plugins']['Cache']['backend'] = $cache->getBackend();
        }

        $debug = new ZFDebug_Controller_Plugin_Debug($options);

        $this->bootstrap('frontController');
        $frontController = $this->getResource('frontController');
        $frontController->registerPlugin($debug);
    }
*/

}

