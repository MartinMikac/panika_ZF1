<?php

/*
 * created on 20.9.2007
 * project: sst-cz
 * author: vlasta
 * version: $
 */
require_once 'Zend/Db/Table/Rowset/Abstract.php';

/**
 * Provides addition information about selected data. 
 *
 */
class Venturia_Db_Rowset_ScrollAble extends Zend_Db_Table_Rowset_Abstract {
	/**
	 * The number of rows per page
	 * 
	 * @var integer
	 */
	protected $_maxResults;
	/**
	 * The number of skipped rows
	 * 
	 * @var integer
	 */
	protected $_firstResult;
	
	/**
	 * How many data rows there are.
	 *
	 * @var integer
	 */
	protected $_countAll;
	
	/**
	 * Constructor.
	 *
	 * @param array $config
	 */
	public function __construct(array $config) {
		parent::__construct ( $config );
		
		if (isset ( $config ['maxResults'] )) {
			$this->_maxResults = $config ['maxResults'];
		}
		
		if (isset ( $config ['firstResult'] )) {
			$this->_firstResult = $config ['firstResult'];
		}
		
		if (isset ( $config ['countAll'] )) {
			$this->_countAll = $config ['countAll'];
		}
	}
	
	/**
	 * Returns the number of skipped rows.
	 * @return int
	 */
	public function maxResults() {
		return $this->_maxResults;
	}
	
	/**
	 * Returns the number of skipped rows.
	 * @return int
	 */
	public function firstResult() {
		return $this->_firstResult;
	}
	
	/**
	 * Returns the number of all elements in the database that fulfills specified conditions.
	 *
	 * @return int
	 */
	public function countAll() {
		return $this->_countAll;
	}
	
	/**
	 * Returns the number of pages.
	 *
	 * @return int
	 */
	public function pages() {
		if ($this->_countAll > 0 && $this->_maxResults > 0) {
			return ceil ( $this->_countAll / $this->_maxResults );
		}
		return 0;
	}
	
	public static function toAssocArray($data, $keyName = 'id', $valueName = 'name') {
		$assocArray = array ( );
		foreach ( $data as $row ) {
			$assocArray [$row [$keyName]] = $row [$valueName];
		}
		return $assocArray;
	}
}