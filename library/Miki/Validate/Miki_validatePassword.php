<?php

/**
 *
 *
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c)  2008 - by Miki  
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: StringLength.php 4974 2007-05-25 21:11:56Z bkarwin $
 */

/**
 * @see Zend_Validate_Abstract
 */
require_once 'Zend/Validate/Abstract.php';

/**
 * @category   Zend
 * @package    Zend_Validate
 * @copyright  Copyright (c) 2005-2007 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Miki_validatePassword extends Zend_Validate_Abstract {
	
	const PASSWORD_MISMATCH = 'heslaNesouhlasi';
	
	/**
	 * @var array
	 */
	protected $_messageTemplates = array (self::PASSWORD_MISMATCH => "'%value%' is less than %min% characters long" );
	
	/**
	 * @var array
	 */
	protected $_messageVariables = array ('min' => '_min', 'max' => '_max' );
	
	/**
	 * Minimum length
	 *
	 * @var integer
	 */
	protected $_min;
	
	/**
	 * Maximum length
	 *
	 * If null, there is no maximum length
	 *
	 * @var integer|null
	 */
	protected $_max;
	
	/**
	 * Sets validator options
	 *
	 * @param  integer $min
	 * @param  integer $max
	 * @return void
	 */
	public function __construct($min = 0, $max = null) {
		$this->setMin ( $min );
		$this->setMax ( $max );
	}
	
	/**
	 * Returns the min option
	 *
	 * @return integer
	 */
	public function getMin() {
		return $this->_min;
	}
	
	/**
	 * Sets the min option
	 *
	 * @param  integer $min
	 * @return Zend_Validate_StringLength Provides a fluent interface
	 */
	public function setMin($min) {
		$this->_min = max ( 0, ( integer ) $min );
		return $this;
	}
	
	/**
	 * Returns the max option
	 *
	 * @return integer|null
	 */
	public function getMax() {
		return $this->_max;
	}
	
	/**
	 * Sets the max option
	 *
	 * @param  integer|null $max
	 * @return Zend_Validate_StringLength Provides a fluent interface
	 */
	public function setMax($max) {
		if (null === $max) {
			$this->_max = null;
		} else {
			$this->_max = ( integer ) $max;
		}
		
		return $this;
	}
	
	/**
	 * Defined by Zend_Validate_Interface
	 *
	 * Returns true if and only if the string length of $value is at least the min option and
	 * no greater than the max option (when the max option is not null).
	 *
	 * @param  string $value
	 * @return boolean
	 */
	public function isValid($value) {
		$valueString = ( string ) $value;
		$this->_setValue ( $valueString );
		$length = strlen ( $valueString );
		if ($length < $this->_min) {
			$this->_error ( self::TOO_SHORT );
		}
		if (null !== $this->_max && $this->_max < $length) {
			$this->_error ( self::TOO_LONG );
		}
		if (count ( $this->_messages )) {
			return false;
		} else {
			return true;
		}
	}

} 