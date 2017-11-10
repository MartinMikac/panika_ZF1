<?php

class Online extends Venturia_Db_Table_Row_Abstract {
	
	
	public static function bind(Zend_Db_Table_Row_Abstract $obj, Zend_Controller_Request_Http $request, $prefix = null, $skipKeys = array()) {
		Venturia_Db_Table_Row_Abstract::bind($obj, $request, $prefix, $skipKeys);		
	}
	
}