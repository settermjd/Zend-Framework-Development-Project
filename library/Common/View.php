<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of View
 *
 * @author matthewsetter
 */
class Common_View extends Zend_View
{
    public function url($urlOptions = array(), $name = null, $reset = false, $encode = true)
    {
        $fc = Zend_Controller_Front::getInstance();
        $router = $fc->getRouter();
        return $router->assemble($urlOptions, $name, $reset, $encode);
    }

    public function escape($var)
    {
        return htmlspecialchars($var, ENT_COMPAT, $this->_encoding);
    }
}
?>
