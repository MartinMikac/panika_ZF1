<?php

class NastaveniController extends Zend_Controller_Action
{

    /**
     * UzivateleView layer
     *
     * @var UzivateleViewService
     */
    private $_uzivateleViewService;

    /**
     * AlertView layer
     *
     * @var AlertViewService
     */
    private $_alertViewService;    

    /**
     * Alert layer
     *
     * @var AlertService
     */
    private $_alertService;
    
    /**
     * Admin layer
     *
     * @var AdminService
     */
    private $_adminService;   

    /**
     * Online layer
     *
     * @var OnlineService
     */
    private $_onlineService;
    
    
	
	function init ()
	{
	    
	    
	    $this->_onlineService = Zend_Registry::get ( 'onlineService' );
	    $this->_uzivateleViewService = Zend_Registry::get ( 'uzivateleViewService' );
	    $this->_alertService = Zend_Registry::get ( 'alertService' );
	    $this->_adminService = Zend_Registry::get ( 'adminService' );
	    $this->_alertViewService = Zend_Registry::get ( 'alertViewService' );
	     	    
	    
	    if (Zend_Auth::getInstance()->hasIdentity() == false) {
	        	
	        $this->_redirect("/login/prihlaseni/");
	    }
	    
	    if (Zend_Auth::getInstance()->hasIdentity() == true) {
	        //LoginController::checkOnline(Zend_Auth::getInstance()->getIdentity()->id_admins);
	        $userOnline = $this->_onlineService->getOnlineByAdminId(Zend_Auth::getInstance()->getIdentity()->id_admins);
	         
	        if ($userOnline == null) {
	            Zend_Auth::getInstance ()->clearIdentity ();
	            $this->_redirect("/login/prihlaseni/");
	        }else {

	            $userOnline->cas_refresh = date('Y-m-d H:i:s');
	            $this->_onlineService->saveOnline($userOnline);
	            
	        }
	        
	    }
	    
	    $userOnlines = $this->_onlineService->getOnlines()->fetchAll();
	     
	    foreach ($userOnlines as $user) {
	        $datetime1 = date_create_from_format('Y-m-d H:i:s', $user->cas_refresh);
	        $datetime2 = date_create('now');
	        $interval = date_diff($datetime1, $datetime2);
	         
	        if( ($interval->y > 0) || ($interval->m > 0) || ($interval->d > 0) || ($interval->h > 0) || ($interval->i > 5) ){
	            $this->_onlineService->deleteOnline($user);
	        }
	         
	         
	    }	    
	    

	    $this->view->cele_jmeno =  Zend_Auth::getInstance()->getIdentity()->cele_jmeno;
	    $this->view->errors = $this->_helper->getHelper('FlashMessenger')->getMessages();	    

	}
	
	function zmenaUdajuAction(){
	    Zend_Debug::dump( Zend_Auth::getInstance()->getIdentity()->id_admins);
	    $admin = $this->_adminService->getAdminById(Zend_Auth::getInstance()->getIdentity()->id_admins);
	     
	    if ($admin == null){
	        $this->_redirect("/login/prihlaseni/");
	    }
	    
	    if ($this->_request->isPost ()) {
	        
	        //$heslo  = $this->_request->getPost ( 'aktualni_heslo' );
	        //$heslo_nove = $this->_request->getPost ( 'nove_heslo' );
	        
	        $telefon_new = $this->_request->getPost ( 'novy_telefon' );
	        $umisteni_new = $this->_request->getPost ( 'nove_umisteni' );
	        
	        
	        if ($umisteni_new == null || $umisteni_new == "" ){
	            $this->_helper->flashMessenger('Zadané pracoviště bylo prázdné - neuloženo!');
	             
	            $this->_redirect("/nastaveni/");
	        }else {

	            $admin->telefon = $telefon_new;
	            $admin->umisteni = $umisteni_new;
	            
	            $this->_adminService->saveAdmin($admin);
	            
	            $this->_helper->flashMessenger('Údaje jsou uloženy!');
	            
	            $this->_redirect("/nastaveni/");
	            
	            
	        }
	        
	        
	        
	        
	        
	        
	        
	    }
	        
	        
	    
	}

	function zmenaHeslaAction(){

	    Zend_Debug::dump( Zend_Auth::getInstance()->getIdentity()->id_admins);
	    $admin = $this->_adminService->getAdminById(Zend_Auth::getInstance()->getIdentity()->id_admins);
	    
	    if ($admin == null){
	        $this->_redirect("/login/prihlaseni/");
	    }
	    
	    if ($this->_request->isPost ()) {
	        $heslo  = $this->_request->getPost ( 'aktualni_heslo' );
	        $heslo_nove = $this->_request->getPost ( 'nove_heslo' );

	        //Zend_Debug::dump($heslo);
	        //Zend_Debug::dump($heslo_nove);
	         
	        
	        if ($heslo_nove == null || $heslo_nove == "" ){
	            //Zend_Debug::dump("nesouhlasi heslo. konec.");
	            
	            $this->_helper->flashMessenger('Zadané nové heslo je prázdné!');
	            
	            $this->_redirect("/nastaveni/");
	        }
	    
	        if (sha1($heslo) == $admin->heslo){
	            $admin->heslo = sha1($heslo_nove);
	            $this->_adminService->saveAdmin($admin);
	            
	            //Zend_Debug::dump("ukladam heslo");
	            $this->_helper->flashMessenger('Heslo nastaveno!');
	            
	            //exit();
	        } else {
	            $this->_helper->flashMessenger('Zadané aktuální heslo je špatně.');
	        }
	    
	    }
	    
	    //exit();
	    
	    //$this->view->notices = "Heslo nastaveno";
	    //$this->_helper->getHelper('FlashMessenger')->getMessages();
	    
	    
	    $this->_redirect("/nastaveni/");
	    
	    
	    //$this->_redirect("/nastaveni");
	}
		

	function indexAction ()
	{
	    
	    $this->view->menu_refresh = 3600;
	    
	    
	    //$uzivatele_view = $this->_uzivateleViewService->getUzivateleViews()->fetchAll();
	    $alert_view = $this->_alertViewService->getAlertViews()->fetchAll();
	    
	    if ($alert_view->count() > 0 ) {
	          
	        $this->view->alerts = $alert_view;
	    }
	    
	    $uzivatel = $this->_adminService->getAdminById(Zend_Auth::getInstance()->getIdentity()->id_admins);
	    
	    $this->view->uzivatel = $uzivatel;
	    
	    
	}
	
	function poslatEmail() {
	    
	    
	    
	    $alert = $this->_alertViewService->getAlertByStatus("alert");
	    $uzivatele = $this->_uzivateleViewService->getUzivateleViews()->fetchAll();
	     
	    //Zend_Debug::dump($alert);
	    //exit();
	    $subject = "";
	    $datum = date("d.m.Y");
	    $subject .= "tlačítko PANIKA spuštěno v ".$alert->cas_start;
	
	     
	    $telo = "<h1 style=\"color: red;\">Stisknuté tlačítko PANIKA! - ". $alert->cele_jmeno   ." </h2>
				<br />
                <div class=\"DivCenter\"> ";
	    $telo .= " <p> ";
	    //$telo .= " <H1 style=\"color: red;\">Stisknuto tlačítko paniky!</H1> ";
	    $telo .= "<br/>";
	    $telo .= "<H3> Jméno: ". $alert->cele_jmeno ."</h3>";
	    //$telo .= "<br/>";
	    $telo .= "<H3> Kde: ". $alert->umisteni ."</h3>";
	    //$telo .= "<br/>";
	    $telo .= "<H3> Telefon: ". $alert->telefon ."</h3>";
	    // $telo .= "<br/>";	    
	
	    $telo .= "</div>";
	
	
	    //*********** FUNKČNÍ ************************
	    $tr = new Zend_Mail_Transport_Smtp("v3");
	    Zend_Mail::setDefaultTransport($tr);
	    //********************************************
	
	    //$transport = new Zend_Mail_Transport_Smtp('smtp.zoho.com', $mailConfig);
	
	    $mail = new Zend_Mail("UTF-8");
	    //$mail->setType(Zend_Mime::MULTIPART_ALTERNATIVE);
	
	    $mail->setFrom('miki@knihovnakv.cz', 'Martin Mikač');
	    $mail->addTo('mikac@knihovnakv.cz', 'Miki'); // my mail account
	    $mail->addTo('sekretariat@knihovnakv.cz', 'Sekretariát'); 
	    $mail->addTo('emler@knihovnakv.cz', 'Emler'); 
	    $mail->addTo('jiracek@knihovnakv.cz', 'Jiracek');
	    $mail->addTo('svobodova@knihovnakv.cz', 'Svobodova');
	    
	    
	    
	    if ($uzivatele != null) {

	        foreach ($uzivatele as $uzivatel){
	            $mail->addTo($uzivatel->email, $uzivatel->cele_jmeno);

	        //    $telo .= "<br/>";
	        //    $telo .= $uzivatel->email;
	        //    $telo .= "<br/>";
	        		}
	        		
	        }	    
	    
	    
	    $mail->setSubject($subject);
	    $mail->setBodyHtml($telo);
	    
	    
	    try {
	        $sent = $mail->send($tr);
	    } catch (Zend_Mail_Exception $e) {
	        die($e);
	    }
	}
	

	
}
