<?php


/*
 * created on 9.10.2007
 * project: bryle-domu-cz
 * author: vlasta
 * version: $
 */

class Venturia_Config_ElEvaluator {
	private $_config;
	private $_strict;
	public function __construct(Zend_Config $config, $strict = false) {
		$this->_config = $config;
		$this->_strict = $strict;
	}
	
	public function evaluate($token) {
		if (is_array ( $token )) {
			$list = explode ( '.', $token [1] );
			
			$value = null;
			foreach ( $list as $subKey ) {
				if ($value == null) {
					$value = $this->_config->get ( $subKey );
				} else {
					$value = $value->get ( $subKey );
				}
				
				if ($value == null) {
					if ($this->_strict) {
						throw new Venturia_Config_El_Exception ( "Key '{$subKey}' not found - " . implode ( '->', $list ) );
					} else {
						return $token [0];
					}
				}
			}
			$token = $value;
		}
		
		return preg_replace_callback ( '|#([\d\w\.]+)#|U', array ($this, 'evaluate' ), $token );
	}
}

class Venturia_Config_El_Exception extends Exception {
}