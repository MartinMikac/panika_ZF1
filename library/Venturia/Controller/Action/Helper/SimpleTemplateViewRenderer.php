<?php


/*
 * created on 18.9.2007
 * project: sst-cz
 * author: vlasta
 * version: $
 */

require_once 'Zend/Controller/Action/Helper/ViewRenderer.php';

class Venturia_Controller_Action_Helper_SimpleTemplateViewRenderer extends Zend_Controller_Action_Helper_ViewRenderer {
	/**
	 * Name of layout script to render. Defaults to 'site.tpl.php'.
	 *
	 * @var string
	 */
	protected $_layoutScript;
	
	/**
	 * Constructor
	 *
	 * Set the viewSuffix to "tpl.php" unless a viewSuffix option is 
	 * provided in the $options parameter.
	 * 
	 * @param  Zend_View_Interface $view 
	 * @param  array $options 
	 * @return void
	 */
	public function __construct(Zend_View_Interface $view = null, array $options = array ()) {
		if (! isset ( $options ['viewSuffix'] )) {
			$options ['viewSuffix'] = 'tpl.php';
		}
		parent::__construct ( $view, $options );
	}
	
	/**
	 * Set the layout script to be rendered.
	 *
	 * @param string $script
	 */
	public function setLayoutScript($script) {
		$this->_layoutScript = $script . '.' . $this->_viewSuffix;
	
	}
	
	/**
	 * Retreive the name of the layout script to be rendered.
	 *
	 * @return string
	 */
	public function getLayoutScript() {
		return $this->_layoutScript;
	}
	
	/**
	 * Render the action script and assign the the view for use
	 * in the layout script. Render the layout script and append
	 * to the Response's body.
	 * 
	 * If there is not layoutScript on 'script' is rendered
	 *
	 * @param string $script
	 * @param string $name
	 */
	public function renderScript($script, $name = null) {
		
		if (null === $name)
			$name = $this->getResponseSegment ();
		
		if ($this->getLayoutScript () == '') {
			$layoutContent = $this->view->render ( $script );
			$this->getResponse ()->appendBody ( $layoutContent, $name );
		} else {
			$this->view->actionScript = $script;
			
			$layoutScript = $this->getLayoutScript ();
			$layoutContent = $this->view->render ( $layoutScript );
			$this->getResponse ()->appendBody ( $layoutContent, $name );
		}
		
		$this->setNoRender ();
	}
	
	public function getName() {
		return 'ViewRenderer';
	}

}