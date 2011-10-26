<?php
// Phly/Resource/Layouthelpers.php
//
class Common_Application_Resource_LayoutHelpers
    extends Zend_Application_Resource_ResourceAbstract
{
    protected $_options = array(
        'doctype'         => 'XHTML1_STRICT',
        'title'           => 'Site Title',
        'title_separator' => ' - ',
    );

    public function init()
    {
        $bootstrap = $this->getBootstrap();
        $bootstrap->bootstrap('View');
        $view = $bootstrap->getResource('View');

        $options = $this->getOptions();

        $view->doctype($options['doctype']);
        $view->headTitle()->setSeparator($options['title_separator'])
        ->append($options['title']);
    }
}