<?php
/**
 *
 * created on 29.03.2016
 * project: panika Button
 * author: Miki
 */

/**
 * Alert service layer class. Contains all business methods associated with @link Alert
 */
class AlertService {

	/**
	 * Alert model
	 * 
	 * @var Alerts
	 */
	private $_alerts;
	
	
	/**
	 * konstruktor
	 *
	 */
	public function __construct() {}
	
	/**
	 * Enter description here...
	 *
	 * @return Alerts
	 */
	
	public function getAlerts() {
		if($this->_alerts == null) {
			$this->_alerts = new Alerts();
		}
		return $this->_alerts;
	}
	
	/**
	 * Najde alerty se zadanými restrikcemi
	 * 
	 * @return Venturia_Db_Table_Rowset_ScrollAble scrollable rowset
	 */
	public function FindAlert($filter = null, $order = null, $maxResults = null, $firstResult = null) {
		return $this->getAlerts()->fetchAllScrollAble($filter, $order, $maxResults, $firstResult);
	}
	
	/**
	 * Vrací Alert podle id
	 * 
	 * @param int $id
	 * @return Alert
	 * 
	 */
	public function getAlertById($id) {
		return $this->getAlerts()->fetchRow(array (
			'id_alert = ?' => $id
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
	    return $this->getAlerts()->fetchRow(array (
	        'status = ?' => $status
	    ));
	}	
	
	/**
	 * Updates or inserts @link Alert to database. 
	 * 
	 * @param Alert $alert
	 */
	public function saveAlert(Alert $alert) {
		return $alert->save();
	}
	
	
	/**
	 * Smaže Alert z databáze
	 * 
	 * @param Alert $alert
	 * smaze @link  Alert  z databaze
	 */
	public  function deleteAlert(Alert $alert){
		return $alert->delete();
	}
	
}

?>
