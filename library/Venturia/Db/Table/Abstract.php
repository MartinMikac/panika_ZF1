<?php


/*
 * created on 20.9.2007
 * project: sst-cz
 * author: vlasta
 * version: $
 */
require_once 'Zend/Db/Table/Abstract.php';

class Venturia_Db_Table_Abstract extends Zend_Db_Table_Abstract {
	
	/**
	 * Fetches all rows.
	 *
	 * Honors the Zend_Db_Adapter fetch mode.
	 *
	 * @param string|array $where            OPTIONAL An SQL WHERE clause.
	 * @param string|array $order            OPTIONAL An SQL ORDER clause.
	 * @param int          $count            OPTIONAL An SQL LIMIT count.
	 * @param int          $offset           OPTIONAL An SQL LIMIT offset.
	 * @return Venturia_Db_Table_Rowset_ScrollAble The scrollable row results per the Zend_Db_Adapter fetch mode.
	 */
	public function fetchAllScrollAble($where = null, $order = null, $count = null, $offset = null, $group = null, $distinct = false) {
		
		$result = $this->_fetchScrollAble ( $where, $order, $count, $offset,$group, $distinct );
		
		$countAll = 0;
		
		$data = array ('table' => $this, 'data' => $result ['data'], 'rowClass' => $this->_rowClass, 'stored' => true, 'maxResults' => $count, 'firstResult' => $offset, 'countAll' => $result ['countAll'] );
		require_once 'Venturia/Db/Rowset/ScrollAble.php';
		return new Venturia_Db_Rowset_ScrollAble ( $data );
	}
	
	/**
	 * Support method for fetching rows.
	 *
	 * @param  string|array $where  OPTIONAL An SQL WHERE clause.
	 * @param  string|array $order  OPTIONAL An SQL ORDER clause.
	 * @param  int          $count  OPTIONAL An SQL LIMIT count.
	 * @param  int          $offset OPTIONAL An SQL LIMIT offset.
	 * @return array The row results, in FETCH_ASSOC mode.
	 */
	protected function _fetchScrollAble($where = null, $order = null, $count = null, $offset = null, $group = null, $distinct = false) {
		
		require_once 'Venturia/Db/Select.php';
		$select = new Venturia_Db_Select ( $this->_db );
		$this->info(self::COLS);

		// the FROM clause
		$select->from ( $this->_name, $this->_cols, $this->_schema );
		
		if ($distinct == true) {
			$select->distinct(true);
		}
		
		if ($group) {
			$select->group($group);
		}
		
		// the WHERE clause
		$where = ( array ) $where;
		
		
		
		foreach ( $where as $key => $val ) {
			// is $key an int?
			if (is_int ( $key )) {
				// $val is the full condition
				$select->where ( $val );
			} else {
				// $key is the condition with placeholder,
				// and $val is quoted into the condition
				$select->where ( $key, $val );
			}
		}
		
		// the ORDER clause
		if (! is_array ( $order )) {
			$order = array ($order );
		}
		foreach ( $order as $val ) {
			$select->order ( $val );
		}
		
		// the LIMIT clause
		$select->limit ( $count, $offset );
		
		// return the results
		$stmtData = $this->_db->query ( $select );
		$data = $stmtData->fetchAll ( Zend_Db::FETCH_ASSOC );
		$stmtSum = $this->_db->query ( $select->getSumSql () );
		$sum = $stmtSum->fetchAll ( Zend_Db::FETCH_ASSOC );
		return array ('data' => $data, 'countAll' => $sum [0] ['sum'] );
	}
	
	public static function toSelectOptions($rowSet, $nameColumn = 'name', &$array = null) {
		if ($array == null)
			$array = array ( );
		foreach ( $rowSet as $row ) {
			if (is_array ( $row ))
				$array [$row ['id']] = $row [$nameColumn]; else
				$array [$row->id] = $row->$nameColumn;
		}
		return $array;
	}
	
	public static function toSelectOptionsNew($rowSet,$idName = "id", $nameColumn = 'name', &$array = null) {
		if ($array == null)
			$array = array ( );
		foreach ( $rowSet as $row ) {
			if (is_array ( $row )){
				$array [$row [$idName]] = $row [$nameColumn];
			}else{
				$array [$row->$idName] = $row->$nameColumn;
			}
				
		}
		return $array;
	}
}