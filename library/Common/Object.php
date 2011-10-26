<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * This is the base object.
 */
class Common_Object
{
    /**
     * @param string
     */
    public function __get($name)
    {
        if (empty($name)) { return FALSE; }

        // all class variables are protected and prefixed with an underscore
        $property = '_' . $name;

        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return FALSE;
    }

    /**
     * @param string
     * @param mixed
     */
    public function __set($name, $value)
    {
        if (empty($name)) { return FALSE; }

        // all class variables are protected and prefixed with an underscore
        $property = '_' . $name;

        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
        return FALSE;
    }

    /**
     *
     */
    public function __toString() {}

    /**
     * A simple helper function to make setting a host of properties in
     * one go, simpler.
     *
     * @param mixed $propertiesList
     */
    public function setProperties($propertiesList)
    {
        if (!is_array($propertiesList) && !is_object($propertiesList)) { return FALSE; }

        // set from an array
        if (is_array($propertiesList) && !empty($propertiesList)) {
            foreach($propertiesList as $propKey => $propValue) {
                $this->$propKey = $propValue;
            }
        }

        // set from an array
        if (is_object($propertiesList)) {
            $properties = get_object_vars($propertiesList);
            foreach($properties as $propKey => $propValue) {
                $this->$propKey = $propValue;
            }
        }
    }
}
