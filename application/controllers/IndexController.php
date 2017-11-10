<?php

class IndexController extends Zend_Controller_Action
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

	}
	

	function indexAction ()
	{
	    $this->view->menu_refresh = 10;
	     
	    $uzivatele_view = $this->_uzivateleViewService->getUzivateleViews()->fetchAll();
	    $alert_view = $this->_alertViewService->getAlertViews()->fetchAll();
	     
	    if ($alert_view->count() > 0 ) {
	        $this->view->alerts = $alert_view;
	    }
	     
	    $this->view->uzivatele = $uzivatele_view;
	}	
	

	private function deleteUnconnected() {
	    
	    
	}
	
	function panikaAction(){
	    
	    if ($this->_request->isPost()) {
	        $new_alert = $this->_alertService->getAlerts()->createRow();
	        
	        $new_alert->status = "alert";
	        $new_alert->cas_start = date('Y-m-d H:i:s');
	        $new_alert->id_admins = Zend_Auth::getInstance()->getIdentity()->id_admins;
	        
	        $this->_alertService->saveAlert($new_alert);
	        
	        //Zend_Debug::dump( "TEST");
	        //Zend_Debug::dump( Zend_Auth::getInstance()->getIdentity());
	        //exit();
	        
	        $this->poslatEmail();
	        

	        	        
	    }
	    
	    $this->_redirect("/");
	}

	
	
	function nastaveniAction(){
	     
	
	}
		

	function panikaVyresenoAction(){
	     
	    if ($this->_request->isPost()) {

	        //$menu[$hodnota->jmeno] = $this->_categoryService->FindCategory(array("id_mainCategories = ?" => $hodnota->id_mainCategories ));
	        $alerts = $this->_alertService->getAlerts()->fetchAll(array("status = ?" => "alert" ));
	        
	        foreach ($alerts as $alert) {
	            //$menu[$hodnota->jmeno] = $this->_categoryService->FindCategory(array("id_mainCategories = ?" => $hodnota->id_mainCategories ));

	            $alert->status = "vyřešeno - vyřešil:".  Zend_Auth::getInstance()->getIdentity()->cele_jmeno;
	            $alert->cas_konec = date('Y-m-d H:i:s');
	            
	          //  Zend_Debug::dump($alert);
	            $this->_alertService->saveAlert($alert);
	        }
	        
	        //exit();
	
	    }

	    $this->poslatEmailVyreseno();
	    
	    $this->_redirect("/");
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
	    $mail->addTo('sektretariat@knihovnakv.cz', 'Němcová - sekretariát'); // my Hotmail account
	    $mail->addTo('emler@knihovnakv.cz', 'Emler'); 
	    $mail->addTo('jiracek@knihovnakv.cz', 'Jiracek'); 
	    $mail->addTo('svobodova@knihovnakv.cz', 'Svobodová'); 
	    
	    if ($uzivatele != null) {

    	    foreach ($uzivatele as $uzivatel){
    	            if ($uzivatel->email != "" || $uzivatel->email != null ) {
    	                   $mail->addTo($uzivatel->email, $uzivatel->cele_jmeno);
    	            }
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
	
	function poslatEmailVyreseno() {
	     
	     
	     
	    //$alert = $this->_alertViewService->getAlertByStatus("alert");
	    $uzivatele = $this->_uzivateleViewService->getUzivateleViews()->fetchAll();
	
	    //Zend_Debug::dump($alert);
	    //exit();
	    $subject = "";
	    $datum = date("d.m.Y");
	    $subject .= "PANIKA ukončena ";
	
	
	    $telo = "<h1 style=\"color: red;\">Panika ukončena uživatelem: " . Zend_Auth::getInstance()->getIdentity()->cele_jmeno . " </h2>
				<br />
                <br />
                <br />
                 
	            ";
	
	    //*********** FUNKČNÍ ************************
	    $tr = new Zend_Mail_Transport_Smtp("v3");
	    Zend_Mail::setDefaultTransport($tr);
	    //********************************************
	
	    //$transport = new Zend_Mail_Transport_Smtp('smtp.zoho.com', $mailConfig);
	
	    $mail = new Zend_Mail("UTF-8");
	    //$mail->setType(Zend_Mime::MULTIPART_ALTERNATIVE);
	
	    $mail->setFrom('miki@knihovnakv.cz', 'Martin Mikač');
	    $mail->addTo('sektretariat@knihovnakv.cz', 'Němcová - sekretariát'); // my Hotmail account
	    $mail->addTo('emler@knihovnakv.cz', 'Emler');
	    $mail->addTo('jiracek@knihovnakv.cz', 'Jiracek');
	    $mail->addTo('svobodova@knihovnakv.cz', 'Svobodová');
	     
	    if ($uzivatele != null) {
	
	        foreach ($uzivatele as $uzivatel){
	            if ($uzivatel->email != "" || $uzivatel->email != null ) {
	                $mail->addTo($uzivatel->email, $uzivatel->cele_jmeno);
	            }
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
