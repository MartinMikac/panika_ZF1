<?php

/**
 * Třída která bude posílat emaily které se budou týkat sekce Clen
 * @author Miki
 * @version 1
 * @package Miki
 * @copyright  Miki - 2008
 *
 */

class Miki_Controller_Mails{
	
	
	 /**
	 * Enter description here...
	 *
	 * @var Miki_Controller_Mails
	 */
	private  $_mails = null;
	
	/**
	 * instance tridy @link Zend_mail
	 *
	 * @var Zend_mail
	 */
	private  $_mail = null;
	
	/**
	 * Konfigurace pro maily
	 *
	 * @var Zend_Config_ini
	 */
	private $_config = null;
	
	
	function Miki_Controller_Mails(){
		$this->_config = Zend_Registry::getInstance ()->get("config");
		
		$trs = new Zend_Mail_Transport_Smtp ( $this->_config->mail->smtpHost );
		$this->_mail = new Zend_Mail ($this->_config->mail->encoding);
		$this->_mail->setDefaultTransport($trs);
		
		Zend_Debug::dump($this->_mail);
		Zend_Debug::dump("-----------------------");
		Zend_Debug::dump($trs);
		exit();
	}
	


	/**
	 * Vrací instanci objektu @link Miki_Controller_Mails pokud není vytvořen, tak jej vytvoří.
	 *
	 * @return Miki_Controller_Mails
	 */

	public function getMail() {
		if(@$this->_mails == null) {
			$this->_mails = new Miki_Controller_Mails();
		}
		return $this->_mails;
	}
	

	
	public function sendNewReport($mailKomu,$jmenoKomu = "")
	{
		
$telo = 'Ahoj,<br />
byl vám zaslán nový report z <a href="http://'.$this->_config->domain->name.'">http://'.$this->_config->domain->name.'</a><br />
<br />
<br />
S pozdravem '.$this->_config->domain->adminName;
		
		
		$this->_mail->setFrom ( $this->_config->domain->adminMail, $this->_config->domain->adminName );
		$this->_mail->addTo ( $mailKomu, $jmenoKomu );
		
		$this->_mail->setSubject ( "Novy report na ".$this->_config->domain->name );
		$this->_mail->setBodyHtml($telo);
	
		
		$this->_mail->send ();
		
	}


}