<?php
/**
 *
 * created on 08.04.2008
 * project: knihovnakv.cz
 * author: Miki
 */

/**
 * AlertView service layer class. Contains all business methods associated with @link AlertView
 */
class AlertViewService {

	/**
	 * AlertView model
	 * 
	 * @var AlertViews
	 */
	private $_alertViews;
	
	
	/**
	 * konstruktor
	 *
	 */
	public function __construct() {}
	
	/**
	 * Enter description here...
	 *
	 * @return AlertViews
	 */
	
	public function getAlertViews() {
		if($this->_alertViews == null) {
			$this->_alertViews = new AlertViews();
		}
		return $this->_alertViews;
	}
	
	/**
	 * Najde se zadanými restrikcemi
	 * 
	 * @return Venturia_Db_Table_Rowset_ScrollAble scrollable rowset
	 */
	public function FindAlertView($filter = null, $order = null, $maxResults = null, $firstResult = null) {
		return $this->getAlertViews()->fetchAllScrollAble($filter, $order, $maxResults, $firstResult);
	}
	
	/**
	 * Vrací poruchu podle id_admins
	 * 
	 * @param int $id
	 * @return AlertView
	 * 
	 */
	public function getAlertViewByAdminId($id) {
		return $this->getAlertViews()->fetchRow(array (
			'id_admins = ?' => $id
		));
	}


	/**
	 * Vrací Alert podle statusu
	 *
	 * @param var $status
	 * @return Alert
	 *
	 */
	public function getAlertByStatus($status) {
	    return $this->getAlertViews()->fetchRow(array (
	        'status = ?' => $status
	    ));
	}	
	
}

?>
