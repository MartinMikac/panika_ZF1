<?php
/*
 * created on 20.9.2007
 * project: sst-cz
 * author: vlasta
 * version: $
 */
require_once 'Zend/Db/Select.php';

class Venturia_Db_Select extends Zend_Db_Select {
	
	/**
	 * Converts this object to an SQL SELECT string that return number of all rows (without offset and limit).
	 *
	 * @return string This object as a SELECT string.
	 */
	public function getSumSql($column = 'sum') {
		// initial SELECT [DISTINCT] [FOR UPDATE]
		$sql = 'SELECT';
		if ($this->_parts [self::DISTINCT]) {
			$sql .= ' DISTINCT';
		}
		
		$sql .= "\n\t";
		
		// add columns
		$columns = array ( );
		$columns [] = "count(*) AS {$column}";
		$sql .= implode ( ",\n\t", $columns );
		
		// from these joined tables
		if ($this->_parts [self::FROM]) {
			$from = array ( );
			foreach ( $this->_parts [self::FROM] as $correlationName => $table ) {
				$tmp = '';
				if (empty ( $from )) {
					// Add schema if available
					if (null !== $table ['schema']) {
						$tmp .= $this->_adapter->quoteIdentifier ( $table ['schema'], true ) . '.';
					}
					// First table is named alone ignoring join information
					$tmp .= $this->_adapter->quoteTableAs ( $table ['tableName'], $correlationName, true );
				} else {
					// Subsequent tables may have joins
					if (! empty ( $table ['joinType'] )) {
						$tmp .= ' ' . strtoupper ( $table ['joinType'] ) . ' ';
					}
					// Add schema if available
					if (null !== $table ['schema']) {
						$tmp .= $this->_adapter->quoteIdentifier ( $table ['schema'], true ) . '.';
					}
					$tmp .= $this->_adapter->quoteTableAs ( $table ['tableName'], $correlationName, true );
					if (! empty ( $table ['joinCondition'] )) {
						$tmp .= ' ON ' . $table ['joinCondition'];
					}
				}
				// add the table name and condition
				// add to the list
				$from [] = $tmp;
			}
			// add the list of all joins
			if (! empty ( $from )) {
				$sql .= "\nFROM " . implode ( "\n", $from );
			}
			
			// with these where conditions
			if ($this->_parts [self::WHERE]) {
				$sql .= "\nWHERE\n\t";
				$sql .= implode ( "\n\t", $this->_parts [self::WHERE] );
			}
			
			// grouped by these columns
			if ($this->_parts [self::GROUP]) {
				$sql .= "\nGROUP BY\n\t";
				$l = array ( );
				foreach ( $this->_parts [self::GROUP] as $term ) {
					$l [] = $this->_adapter->quoteIdentifier ( $term, true );
				}
				$sql .= implode ( ",\n\t", $l );
			}
			
			// having these conditions
			if ($this->_parts [self::HAVING]) {
				$sql .= "\nHAVING\n\t";
				$sql .= implode ( "\n\t", $this->_parts [self::HAVING] );
			}
		}
		return $sql;
	}
}