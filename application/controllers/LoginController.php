<?php

class LoginController extends Zend_Controller_Action
{

    /**
     * Online layer
     *
     * @var OnlineService
     */
    private $_onlineService;

    /**
     * Admin layer
     *
     * @var AdminService
     */
    private $_adminService;    
    

	function init ()
	{
	    
	    $this->_onlineService = Zend_Registry::get ( 'onlineService' );
	    $this->_adminService = Zend_Registry::get ( 'adminService' );
	  //$this->_machineService = Zend_Registry::get ( 'machineService' );
	}

	function indexAction ()
	{
	    if (Zend_Auth::getInstance()->hasIdentity() == false) {
	    
	        $this->_redirect("/login/prihlaseni/");
	    }
	    
	    
	    if (Zend_Auth::getInstance()->hasIdentity() == true) {
	         
	        //$this->_onlineService->getOnlineByAdminId(Zend_Auth::getInstance()->getIdentity()->id_admins);
	        
	        $this->checkOnline(Zend_Auth::getInstance()->getIdentity()->id_admins);
	        
	        
	    }	    
	     
	    $this->view->title = "Admin sekce - ".Zend_Auth::getInstance()->getIdentity()->jmeno;
	    $this->view->notices = $this->_helper->getHelper('FlashMessenger')->getMessages();

	}
	
	
	function checkOnline($id_admins) {
	    
	    $userOnline = $this->_onlineService->getOnlineByAdminId(Zend_Auth::getInstance()->getIdentity()->id_admins);
	    
	    if ($userOnline == null) {
	        Zend_Auth::getInstance ()->clearIdentity ();
	        $this->_redirect("/login/prihlaseni/");
	    }
	    
	    
	    
	    
	}
	
	function prihlaseniAction() {
	    if ($this->_request->isPost ()) {
	
	        $filter = new Zend_Filter_StripTags ( );
	        $jmeno = $filter->filter ( $this->_request->getPost ( 'jmeno' ) );
	        $jmeno = trim ( $jmeno );
	        $heslo = trim ( $filter->filter ( $this->_request->getPost ( 'heslo' ) ) );
	
	        $db = Zend_Registry::get ( "db" );
	
	        //$authAdapter = new Zend_Auth_Adapter_Ldap();
	        
	        $authAdapter = new Zend_Auth_Adapter_DbTable ( $db );
	        
	        $authAdapter->setTableName ( 'Admins' );
	        $authAdapter->setIdentityColumn ( 'jmeno' );
	        $authAdapter->setCredentialColumn ( 'heslo' );
	        $authAdapter->setIdentity ( $jmeno );
	        $authAdapter->setCredential ( $heslo );
	        $authAdapter->setCredentialTreatment ( "SHA1(?)" );
	
	
	        $auth = Zend_Auth::getInstance ();
	        $result = $auth->authenticate ( $authAdapter );
	
	        $namespace = new Zend_Session_Namespace('Zend_Auth');
	        //$namespace->setExpirationSeconds(28800);
	
	        if ($result->isValid ()) {
	            $data = $authAdapter->getResultRowObject ( null, 'heslo' );
	            $auth->getStorage ()->write ( $data );
	            
	            //Zend_Debug::dump(Zend_Auth::getInstance()->getIdentity()->id_admins);

	            
	            $loged_admin = $this->_adminService->getAdminById(Zend_Auth::getInstance()->getIdentity()->id_admins);

	            $last_online = $this->_onlineService->getOnlineByAdminId(Zend_Auth::getInstance()->getIdentity()->id_admins);
	            
	            if ($last_online != null) {
	                $this->_onlineService->deleteOnline($last_online);
	            }
	            
	            
                $online =  $this->_onlineService->getOnlines()->createRow();
                
                $online->id_admins = $loged_admin->id_admins;
                $online->status = "normal";
                $online->cas_prihlaseni = date('Y-m-d H:i:s');
                $online->cas_refresh = date('Y-m-d H:i:s');
                
                
                $this->_onlineService->saveOnline($online);
                
                
                $loged_admin->last_online = date('Y-m-d H:i:s'); 
                $this->_adminService->saveAdmin($loged_admin);
	            
	            $this->_redirect("/");
	
	        } else {
	            $this->view->title = "Jméno nebo heslo bylo zadáno chybně";
	        }
	    }
	}
	
	function odhlaseniAction() {
	
	    if (Zend_Auth::getInstance ()->hasIdentity ()) {
	        
        
	        $last_online = $this->_onlineService->getOnlineByAdminId(Zend_Auth::getInstance()->getIdentity()->id_admins);

	        if ($last_online != null) {
	            $this->_onlineService->deleteOnline($last_online);
	        }
	        	        
	        	        	        
	        Zend_Auth::getInstance ()->clearIdentity ();
	        $this->view->result = "Úspěšne odhlášeno ze systému";
	    } else {
	        $this->view->result = "Nejste přihlášen";
	    }
	
	    $this->_redirect("/");
	}
	
	function shaAction(){
	    if ($this->_request->isPost ()) {
	        $jmeno  = $this->_request->getPost ( 'heslo' );
	
	        $this->view->title = sha1($jmeno);
	        	
	    }
	}
	
}
