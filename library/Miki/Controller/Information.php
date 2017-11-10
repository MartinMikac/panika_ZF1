<?php
/**
 * Třída která vrací IP adresu pocítace + další informace 
 *@author Miki
 * @version 1
 * @copyright  Miki - 2008
 * @package Miki 
 */

class Miki_Controller_Information {


	/**
	 * Enter description here...
	 *
	 * @var Miki_Controller_Information
	 */
	private  $_mikiInformation = null;

	/**
	 * Vrací instanci objektu @link  Miki_Controller_Information pokud není vytvořen, tak jej vytvoří.
	 *
	 * @return Miki_Controller_Information
	 */

	public function getInformation() {
		if(@$this->_mikiInformation == null) {
			$this->_mikiInformation = new Miki_Controller_Information();
		}
		return $this->_mikiInformation;
	}

	/**
	 * ziska ip adresu odkus se prihlasuje, jmeno pc + ip proxy
	 * @return string
	 */
	public function getRemoteInfo () {
		$proxy="";
		$IP = "";
		if (isSet($_SERVER)) {
			if (isSet($_SERVER["HTTP_X_FORWARDED_FOR"])) {
				$IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
				$proxy  = $_SERVER["REMOTE_ADDR"];
			} elseif (isSet($_SERVER["HTTP_CLIENT_IP"])) {
				$IP = $_SERVER["HTTP_CLIENT_IP"];
			} else {
				$IP = $_SERVER["REMOTE_ADDR"];
			}
		} else {
			if ( getenv( 'HTTP_X_FORWARDED_FOR' ) ) {
				$IP = getenv( 'HTTP_X_FORWARDED_FOR' );
				$proxy = getenv( 'REMOTE_ADDR' );
			} elseif ( getenv( 'HTTP_CLIENT_IP' ) ) {
				$IP = getenv( 'HTTP_CLIENT_IP' );
			} else {
				$IP = getenv( 'REMOTE_ADDR' );
			}
		}
		if (strstr($IP, ',')) {
			$ips = explode(',', $IP);
			$IP = $ips[0];
		}
		$RemoteInfo[0]=$IP;
		$RemoteInfo[1]=@GetHostByAddr($IP);
		$RemoteInfo[2]=$proxy;
		return $RemoteInfo[0]."#".$RemoteInfo[1]."#".$RemoteInfo[2];
	}

	/**
	 * vygeneruje heslo max delka je 32
	 *
	 * @param int $length max 32, default 8
	 * @return string
	 */

	public function genPass($length = 8) //max length = 32 characters
	{
		return substr(md5(uniqid(rand(), true)), 0, $length);
	}

	/**
	 * Vrátí aktuální datum a čas formátovaný pro MySQL db
	 *
	 * @return date
	 */
	public function getMysqlAktualniCas() {
		return date ("Y-m-d H:i:s");
	}
	
	/**
	 * Funkce vrací ze zadaneho poctu sekund pole - hodiny,minuty,sekundy
	 *
	 * @param int $sekundy
	 * @return array
	 */

	function preved_cas ($sekundy)
	{
		if ($sekundy >= 3600){
			$re = $sekundy % 3600;
			$cas['hodiny'] = ($sekundy - $re) / 3600;
			$sekundy = $re;
		}
		if ($sekundy >= 60){
			$re = $sekundy % 60;
			$cas['minuty'] = ($sekundy - $re) / 60;
			$sekundy = $re;
		}
		$cas["sekundy"] = $sekundy;

		return $cas;
	}
}

?>