<?php


/**
 * project: galerie
 * @author Miki
 * @version 1
 * @copyright  Miki  - 2008
 */

class ErrorController extends Zend_Controller_Action {

	
	function init ()
	{
	    
	    if (Zend_Auth::getInstance()->hasIdentity() == false) {
	    
	        $this->_redirect("/login/prihlaseni/");
	    }

	}
	
	function indexAction() {

		$this->_forward("error404");
		return;

	}	

	/**
	 * This action handles  
	 *    - Application errors
	 *    - Errors in the controller chain arising from missing 
	 *      controller classes and/or action methods
	 */

	public function errorAction() {
		$errors = $this->getRequest()->getParam('error_handler');
		if($errors != null) {
			switch ($errors->type) {
				case Zend_Controller_Plugin_ErrorHandler :: EXCEPTION_NO_CONTROLLER :
				case Zend_Controller_Plugin_ErrorHandler :: EXCEPTION_NO_ACTION :
					$this->_forward('error404');
					return;
				default :
					$this->getResponse()->setRawHeader('HTTP/1.1 500 Internal Server Error');
					$exception = $errors->exception;
	                $log = new Zend_Log(new Zend_Log_Writer_Stream('../tmp/applicationException.log'));
	                $log->debug($exception->getMessage() . "\n" .  $exception->getTraceAsString());					
					break;
			}
		}
		
		$message = $this->_request->getParam('message');
		if($message != null) {
			$this->view->message = $message;
		}
		$this->getResponse()->clearBody();
		$this->view->title = 'Chyba';
	}

	public function error404Action() {
		$this->getResponse()->setRawHeader('HTTP/1.1 404 Not Found');
		$this->view->title = 'Chyba 404 - stránka nenalezena';
	}
	
	
	public function nedostatecneopravneniAction() {
		$this->view->title = 'Nedostatečné oprávnění pro provedení této akce!';
	}
	

	
	
}