<?php


/*
 * created on 25.9.2007
 * project: sst-cz
 * author: vlasta
 * version: $
 */
require_once 'Zend/Acl/Assert/Interface.php';

/**
 * Plugin for URL based authorization
 */
class Venturia_Acl_Assert_DomainObjectAssertion implements Zend_Acl_Assert_Interface {
	/**
	 * Array of rules. Every array is array with following keys:
	 * roles				- array of roles. For success current user must have at least one. Use comma to set multiple required roles
	 * objProperty			- object property that contains information about 
	 * authorityProperty	- authority property to match agains
	 * 
	 * @var array 
	 */
	protected $_rules;
	
	/**
	 * Array of authority properties. Must contains array of roles.
	 * 
	 * @var array 
	 */
	protected $_authorityProperties;
	
	/**
	 * Domain object to protect
	 * 
	 * @var object domain object
	 */
	protected $_domainObject;
	
	/**
	 * @param array rules array of URL rules
	 * @param Zend_Controller_Request_Http request Request object - we need logged user and requestUri
	 */
	public function __construct(array $rules, array $authorityProperties, $domainObject) {
		$this->_rules = $rules;
		$this->_authorityProperties = $authorityProperties;
		$this->_domainObject = $domainObject;
	}
	
	public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null) {
		
		if (sizeof ( $this->_rules ) == 0)
			return false;
		if (sizeof ( $this->_authorityProperties ) == 0)
			return false;
		if (! array_key_exists ( 'roles', $this->_authorityProperties ))
			return false;
		$authorityRoles = $this->_authorityProperties ['roles'];
		
		foreach ( $this->_rules as $rule ) {
			$intersect = array_intersect ( $rule ['roles'], $authorityRoles );
			if (sizeof ( $intersect ) > 0) {
				if ($this->_authorityProperties [$rule ['authorityProperty']] == $this->_domainObject->{$rule ['objProperty']}) {
					return true;
				}
			}
		}
		return false;
	}
}