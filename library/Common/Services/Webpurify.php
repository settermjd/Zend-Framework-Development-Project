<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Webpurify
 *
 * @author settermj
 */
class Common_Services_Webpurify
{
    protected $_apiKey = NULL;
    protected $_accountName = NULL;
    protected $_emailAddress = NULL;
    protected $_url = NULL;

    /**
     *
     * @param <type> $options
     */
    public function __construct($options)
    {
        $this->_apiKey = $options['key'];
        $this->_accountName = $options['account_name'];
        $this->_emailAddress = $options['email_address'];
        $this->_url = $options['url'];
    }

    public function isValid($data) {

    }

}
?>
