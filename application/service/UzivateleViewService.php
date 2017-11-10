<?php
/**
 *
 * created on 08.04.2008
 * project: knihovnakv.cz
 * author: Miki
 */

/**
 * UzivateleView service layer class. Contains all business methods associated with @link UzivateleView
 */
class UzivateleViewService {

	/**
	 * UzivateleView model
	 * 
	 * @var UzivateleViews
	 */
	private $_uzivateleViews;
	
	
	/**
	 * konstruktor
	 *
	 */
	public function __construct() {}
	
	/**
	 * Enter description here...
	 *
	 * @return UzivateleViews
	 */
	
	public function getUzivateleViews() {
		if($this->_uzivateleViews == null) {
			$this->_uzivateleViews = new UzivateleViews();
		}
		return $this->_uzivateleViews;
	}
	
	/**
	 * Najde se zadanými restrikcemi
	 * 
	 * @return Venturia_Db_Table_Rowset_ScrollAble scrollable rowset
	 */
	public function FindUzivateleView($filter = null, $order = null, $maxResults = null, $firstResult = null) {
		return $this->getUzivateleViews()->fetchAllScrollAble($filter, $order, $maxResults, $firstResult);
	}
	
	/**
	 * Vrací poruchu podle id_admins
	 * 
	 * @param int $id
	 * @return UzivateleView
	 * 
	 */
	public function getUzivateleViewByAdminId($id) {
		return $this->getUzivateleViews()->fetchRow(array (
			'id_admins = ?' => $id
		));
	}	
	
}

?>
