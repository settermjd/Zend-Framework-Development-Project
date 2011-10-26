<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Akismet Service
 *
 * @author settermj
 */
class Common_Services_Akismet extends Common_Object
{
    protected $_apiKey = NULL;
    protected $_username = NULL;
    protected $_password = NULL;
    protected $_url = NULL;
    protected $_akismet = NULL;

    /**
     *
     * @param <type> $options
     */
    public function __construct($options)
    {
        $this->_apiKey = $options['key'];
        $this->_username = $options['username'];
        $this->_password = $options['password'];
        $this->_url = $options['url'];
    }

    public function isValid($data) {

    }

    public function getFilterData($data=array())
    {
        if (empty($data)) {
            return NULL;
        } else {
            // initialise the service before executing
            if (!empty($this->_apiKey) && !empty($this->_url)) {
                $this->_akismet = new Zend_Service_Akismet(
                    $this->_apiKey,
                    $this->_url
                    );

                if (!$this->_akismet->verifyKey()) {
                    return NULL;
                }
            } else {
                return NULL;
            }

            $data = array_merge(
                $data,
                $_SERVER,
                array(
                    'user_ip' => $_SERVER['REMOTE_ADDR'],
                    'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                    )
                );
        }
        return $data;
    }


    /**
     * This has been setup to allow for magical extension to the object.
     *
     * Possibly do some logging here.
     *
     * @param <type> $name
     * @param <type> $arguments
     */
    public function __call($name, $arguments)
    {
        if (!is_null($this->_akismet)) {
            return $this->_akismet->$name($arguments[0]);
        }
    }
}
?>
