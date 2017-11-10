<?php

class DbConnectPlugin extends Zend_Controller_Plugin_Abstract {
	
	private $_dbSettings;
	private $_db;
	
	public function __construct(array $dbSettings) {
		$this->_dbSettings = $dbSettings;
	}
	
	/**
	 * Establish connection to database. If connection fails we go to @link ErrorController.
	 *
	 * @param  Zend_Controller_Request_Abstract $request
	 * @return void
	 */
	public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request) {
		try {
			$this->_db = Zend_Db::factory ( $this->_dbSettings ['driver'], $this->_dbSettings );
			$this->_db->query ( 'set names ' . $this->_dbSettings ['encoding'] );
			//if ($this->_dbSettings ['profiler'] == true)
				$this->_db->getProfiler ()->setEnabled ( true );
			
			Zend_Db_Table_Abstract::setDefaultAdapter ( $this->_db );
			Zend_Registry::set ( 'db', $this->_db );
		
		} catch ( Exception $e ) {
			
			$front = $frontController = Zend_Controller_Front::getInstance ();
			if ($front->throwExceptions ()) {
				throw $e;
			}
			
			$error = new ArrayObject ( array ( ), ArrayObject::ARRAY_AS_PROPS );
			$exception = $e;
			$exceptionType = get_class ( $e );
			$error->exception = $exception;
			$error->type = Zend_Controller_Plugin_ErrorHandler::EXCEPTION_OTHER;
			
			$request->setParam ( 'message', 'Došlo k chybě při spojení s databází' );
			
			// Keep a copy of the original request
			$error->request = clone $request;
			
			$errorHandler = $front->getPlugin ( 'Zend_Controller_Plugin_ErrorHandler' );
			
			$request->setParam ( 'error_handler', $error )->setModuleName ( $errorHandler->getErrorHandlerModule () )->setControllerName ( $errorHandler->getErrorHandlerController () )->setActionName ( $errorHandler->getErrorHandlerAction () )->setDispatched ( false );
		}
	}
	
	/* Called before Zend_Controller_Front exits its dispatch loop.
     *
     * @return void
     */
	public function dispatchLoopShutdown() {
		if ($this->_dbSettings ['profiler'] == true) {
			$profiler = $this->_db->getProfiler ();
			
			$totalTime = $profiler->getTotalElapsedSecs ();
			$queryCount = $profiler->getTotalNumQueries ();
			$longestTime = 0;
			$longestQuery = null;
			
			$out = "<div style='float: left;'>
			<br />
			";
			
			foreach ( $profiler->getQueryProfiles () as $query ) {
				$out .= $query->getQuery () . " <br /><br />
";
				if ($query->getElapsedSecs () > $longestTime) {
					$longestTime = $query->getElapsedSecs ();
					$longestQuery = $query->getQuery ();
				}
			}
			$out .= "<br/>";
			$out .= 'Executed ' . $queryCount . ' queries in ' . $totalTime . ' seconds<br/>';
			$out .= 'Average query length: ' . $totalTime / $queryCount . ' seconds<br/>';
			$out .= 'Queries per second: ' . $queryCount / $totalTime . '<br/>';
			$out .= 'Longest query length: ' . $longestTime . '<br/>';
			$out .= "Longest query: " . $longestQuery . '<br/>';
			$out .= "</div>
			
			</div></div></body></html>";
			
			$this->_response->appendBody ( $out );
		}
	}
}




?>

