<?php

class PanikaController extends Zend_Controller_Action
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
    
    
	
	function init ()
	{
	    
	    //Zend_Debug::dump(Zend_Auth::getInstance()->getIdentity());
	    //$this->_machineService = Zend_Registry::get ( 'machineService' );
	    $this->_uzivateleViewService = Zend_Registry::get ( 'uzivateleViewService' );
	    $this->_alertService = Zend_Registry::get ( 'alertService' );
	    $this->_adminService = Zend_Registry::get ( 'adminService' );
	    $this->_alertViewService = Zend_Registry::get ( 'alertViewService' );
	    
	}
	
	function kompletniSeznamAction(){
//	    $machines = $this->_machineService->getMachines()->fetchAll();
//	    $this->view->machines = $machines;
	    
	    
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
	        	        
	    }
	    
	    $this->_redirect("/");
	}
	

	function panikaVyresenoAction(){
	     
	    if ($this->_request->isPost()) {

	        //$menu[$hodnota->jmeno] = $this->_categoryService->FindCategory(array("id_mainCategories = ?" => $hodnota->id_mainCategories ));
	        $alerts = $this->_alertService->getAlerts()->fetchAll(array("status = ?" => "alert" ));
	        
	        foreach ($alerts as $alert) {
	            //$menu[$hodnota->jmeno] = $this->_categoryService->FindCategory(array("id_mainCategories = ?" => $hodnota->id_mainCategories ));

	            $alert->status = "vyřešeno";
	            $alert->cas_konec = date('Y-m-d H:i:s');
	            
	          //  Zend_Debug::dump($alert);
	            $this->_alertService->saveAlert($alert);
	        }
	        
	        //exit();
	
	    }
	     
	    $this->_redirect("/");
	}	

	function indexAction ()
	{
	    
	    
	    
	    $alert_view = $this->_alertViewService->getAlertViews()->fetchAll();
	    
	    if ($alert_view->count() > 0 ) {
	          
	        $this->view->alerts = $alert_view;
	    }
	    
	    
	    
	    
	    //Zend_Debug::dump($uzivatele_view);
	    
	    
		
		
		/*
		
		$mainCats =  $this->_mainCategoryService->FindMainCategory();
		
		
		foreach ($mainCats as $hodnota) {
			$menu[$hodnota->jmeno] = $this->_categoryService->FindCategory(array("id_mainCategories = ?" => $hodnota->id_mainCategories ));
		}		
		
		
		
		$this->view->title = "Výšivky všeho druhu - SuperVysivky.cz";
		$this->view->notices = $this->_helper->getHelper('FlashMessenger')->getMessages();
		
		$kosik = new Zend_Session_Namespace("kosik");
        */		
	}
	

	
}
