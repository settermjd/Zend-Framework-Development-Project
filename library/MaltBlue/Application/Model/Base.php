<?php

class MaltBlue_Application_Model_Base
{
	/**
	 * @var mixed $_logger - A handle on a log writer
	 */
	protected $_logger = null;
	
	protected $_cache = null;
	
	/**
	 * This is a simple class constructor that sets properties for the
	 * class on an as-needed basis.
	 */
	public function __construct(array $config=array())
	{
		if (!empty($config)) {
			foreach ($config as $key => $value) {
				if (property_exists(__CLASS__, "_" . $key) && !empty($value)) {
					$propertyName = "_" . $key;
					$this->$propertyName = $value;
				}
			}
		}
	}
	
	public function _log($logLevel, $logMessage)
	{
	    if (isset($this->_logger)) {
            return $this->_logger->$logLevel($logMessage);
        }
	}
}