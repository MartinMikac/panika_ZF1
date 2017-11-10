<?php
/**
 *
 * created on 22.03.2016
 * project: panika
 * author: Miki
 */

/**
 * Basket service layer class. Contains all business methods associated with @link Basket
 */
class OnlineService {

	/**
	 * Online model
	 * 
	 * @var Onlines
	 */
	private $_onlines;
	
	
	/**
	 * konstruktor
	 *
	 */
	public function __construct() {}
	
	/**
	 * Enter description here...
	 *
	 * @return Baskets
	 */
	
	public function getOnlines() {
		if($this->_onlines == null) {
			$this->_onlines = new Onlines();
		}
		return $this->_onlines;
	}
	
	/**
	 * Najde kategorie se zadanými restrikcemi
	 * 
	 * @return Venturia_Db_Table_Rowset_ScrollAble scrollable rowset
	 */
	public function FindOnline($filter = null, $order = null, $maxResults = null, $firstResult = null) {
		return $this->getOnlines()->fetchAllScrollAble($filter, $order, $maxResults, $firstResult);
	}
	
	/**
	 * Vrací online podle id
	 * 
	 * @param int $id
	 * @return Online
	 * 
	 */
	public function getOnlineByAdminId($id) {
		return $this->getOnlines()->fetchRow(array (
			'id_admins = ?' => $id
		));
	}	
	

	/**
	 * Vrací odpojene uzivatele. Tj. neativní déle jak 5 minut
	 *
	 * 
	 * @return Online
	 *
	 */
	public function getOnlineOld($id) {
	    return $this->getOnlines()->fetchRow(array (
	        'cas_prihlaseni = ?' => $id
	    ));
	}	
	
	
	/**
	 * Updates or inserts @link Online to database. 
	 * 
	 * @param Online $online
	 */
	public function saveOnline(Online $online) {
		return $online->save();
	}
	
	
	/**
	 * Smaže online z databáze
	 * 
	 * @param Online $online
	 * smaze @link Online  z databaze
	 */
	public  function deleteOnline(Online $online){
		return $online->delete();
	}
	



	
}

?>
