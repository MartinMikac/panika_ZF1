<?php
/*
 * created on 1.10.2007
 * project: bryle-domu-cz
 * author: vlasta
 * version: $
 */
require_once 'Zend/Db/Table/Row/Abstract.php';

class Venturia_Db_Table_Row_Abstract extends Zend_Db_Table_Row_Abstract {
	
	public static function bind(Zend_Db_Table_Row_Abstract $obj, Zend_Controller_Request_Http $request, $prefix = null, $skipKeys = array()) {
		$immutables = array ('id' );
		foreach ( $obj->_data as $key => $value ) {
			$requestKey = ($prefix != null ? $prefix : '') . $key;
			if (in_array ( $key, $immutables ) || in_array ( $key, $skipKeys ))
				continue;
			if ($request->{$requestKey} !== null) {
				$obj->{$key} = $request->{$requestKey};
			}
		}
	}
}