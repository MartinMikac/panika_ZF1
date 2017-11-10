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
class Venturia_Acl_Assert_UrlBasedAssertion implements Zend_Acl_Assert_Interface {
	/**
	 * Array of URL rules
	 * 
	 * @var array 
	 */
	protected $_rules;
	
	/**
	 * Request object
	 * 
	 * @var Zend_Controller_Request_Http
	 */
	protected $_request;
	
	/**
	 * Gives additional information about authorization process
	 */
	protected $_flag = null;
	
	const ACCESS_DENIED = 'ACCESS_DENIED';
	const NO_LOGGED_USER = 'NO_LOGGED_USER';
	const NO_MATCHING_RULE = 'NO_MATCHING_RULE';
	
	/**
	 * If unsucessfull authorization then contains information about nonmatching rule
	 */
	protected $_nonMatchingRule = null;
	
	/**
	 * @param array rules array of URL rules
	 * @param Zend_Controller_Request_Http request Request object - we need logged user and requestUri
	 */
	public function __construct(array $rules, array $accessDeniedRules, Zend_Controller_Request_Http $request) {
		$this->_rules = $rules;
		$this->_request = $request;
	}
	
	public function getNonMatchningRule() {
		return $this->_nonMatchingRule;
	}
	
	public function getFlag() {
		return $this->_flag;
	}
	
	public function assert(Zend_Acl $acl, Zend_Acl_Role_Interface $role = null, Zend_Acl_Resource_Interface $resource = null, $privilege = null) {
		$userRole = 'ANONYMOUS';
		if ($this->_request->getParam ( 'user' ) != null) {
			$userRole = $this->_request->getParam ( 'user' )->authority;
		}
		$currentUrl = trim ( $this->_request->getRequestUri (), '/' );
		
		foreach ( $this->_rules as $rule ) {
			$regex = "/" . str_replace ( "/", "\/", $rule ['regex'] ) . "/i";
			preg_match ( $regex, $currentUrl, $_matched );
			if (sizeof ( $_matched ) > 0) {
				$roles = explode ( ',', $rule ['roles'] );
				foreach ( $roles as $role ) {
					if ($userRole === trim ( $role )) {
						return true;
					}
					// uzivatel nema prislusna prava
					if ($userRole === 'ANONYMOUS') {
						$this->_flag = self::NO_LOGGED_USER;
					} else {
						$this->_flag = self::ACCESS_DENIED;
					}
					$this->_nonMatchingRule = $rule;
					return false;
				}
			}
		}
		$this->_flag = self::NO_MATCHING_RULE;
		return false;
	}
}