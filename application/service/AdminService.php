<?php
/**
 *
 * created on 08.04.2008
 * project: panic
 * author: Miki
 */

/**
 * Basket service layer class. Contains all business methods associated with @link Basket
 */
class AdminService {

	/**
	 * Admin model
	 * 
	 * @var Admins
	 */
	private $_admins;
	
	
	/**
	 * konstruktor
	 *
	 */
	public function __construct() {}
	
	/**
	 * Enter description here...
	 *
	 * @return Admins
	 */
	
	public function getAdmins() {
		if($this->_admins == null) {
			$this->_admins = new Admins();
		}
		return $this->_admins;
	}
	
	/**
	 * Najde kategorie se zadanými restrikcemi
	 * 
	 * @return Venturia_Db_Table_Rowset_ScrollAble scrollable rowset
	 */
	public function FindAdmin($filter = null, $order = null, $maxResults = null, $firstResult = null) {
		return $this->getBaskets()->fetchAllScrollAble($filter, $order, $maxResults, $firstResult);
	}
	
	/**
	 * Vrací uzivatele podle id
	 * 
	 * @param int $id
	 * @return Admin
	 * 
	 */
	public function getAdminById($id) {
		return $this->getAdmins()->fetchRow(array (
			'id_admins = ?' => $id
		));
	}	
	
	/**
	 * Updates or inserts @link Member to database. 
	 * 
	 * @param Admin $admin
	 */
	public function saveAdmin(Admin $admin) {
		return $admin->save();
	}
	
	
	/**
	 * Smaže Admina z databáze
	 * 
	 * @param Admin $admin
	 * smaze @link  Admin  z databaze
	 */
	public  function deleteAdmin(Admin $admin){
		return $admin->delete();
	}
	
}

?>
