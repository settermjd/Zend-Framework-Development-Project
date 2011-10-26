<?php
/**
* This class provides a simple object to pass error information in the application
*
* @category   MaltBlue
* @package    MaltBlue_Application
* @subpackage Error
* @copyright  Copyright (c) 2005-2012 Malt Blue Limited. (http://www.maltblue.com)
* @license    http://framework.zend.com/license   BSD License
* @link       http://framework.zend.com/package/PackageName
* @since      File available since Release 1.0.0
*/
class MaltBlue_Application_Error 
{
	/**
	 * @var int Stores a code representing the error
	 */
	protected $_code = null;

	/**
	 * @var string Stores a brief representation of the error
	 */
	protected $_message = null;

	/**
	 * @var string Stores a long(er) representation of the error
	 */	
	protected $_description = null;
	
	/**
	 * Make it simple to retrieve object properties
	 *
	 * @param string $key The name of the property to get
	 * @return mixed The value of the property - if it's available or FALSE otherwise
	 */
	public function __get($key) 
	{
		if (!empty($key)) {
			$propertyName = "_" . $key;
			if (property_exists(__CLASS__, $propertyName)) {
				return $this->$propertyName;
			}
		}
		return FALSE;
	}
	
	/**
	 * Make it simple to set object property values.
	 * It will do nothing if the property is not available
	 *
	 * @param string $key The name of the property to set
	 * @param mixed $value The value to set the property to
	 * @return self 
	 */
	public function __set($key, $value) 
	{
		if (!empty($key) && !empty($value)) {
			$propertyName = "_" . $key;
			if (property_exists(__CLASS__, $propertyName)) {
				$this->$propertyName = $value;
			}
		}
		return $this;
	}
}