<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Factory
 *
 * @author matthew.setter
 */
class Common_Services_Factory
{
    /**
     *
     */
    const CLASS_PREFIX = 'Common_Services_';

    /**
     * private constructor to avoid instantiation
     */
    private function __construct() {}

    /**
     *
     * @param string $connectionType
     * @param string $sourceName
     * @param <type> $options
     * @return responseClass
     * @todo throw an exception on fail. potentiall have the factories, descend from a common base class
     */
    static public function factory($serviceType, Array $options=array())
    {
        if (empty($serviceType)) { return FALSE; }

        // split to match underscore naming
        $classSuffix = explode('_', $serviceType);
        $it = new ArrayIterator($classSuffix);
        $tmp = array();

        foreach($it as $item) {
            $tmp[] = ucfirst(strtolower($item));
        }

        $classSuffix = $tmp;
        $responseClass = self::CLASS_PREFIX . implode('_', $classSuffix);

        try {
            return new $responseClass($options);
        } catch(Exception $e) {
            // do something on failed instanatiation
        }
    }
}
?>