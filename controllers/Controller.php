<?php
/**
 * The Controller base class s defines a controller as a controller and contains all the required base functionalities.
 *
 * @author Mike Mclaren <mike.mclaren@sq1.com>
 **/

class Controller {
	public $model;
	protected $view;
	protected $vars;
	
	public function __construct($params = NULL) {
		$this->params = $params;
	}

	protected function getViewFilePath() {
		$name = str_replace('Controller', '', get_class($this));
		return VIEWS . $name . DS;
	}

	/**
	 * By default, all controllers have an index function,
	 * which mostly serves as an example, really. Doesn't
	 * ever need to be defined.
	 */
	public function index($params = null) {
		include $this->getViewFilePath() . 'index.php';
	}

	public function execute() {
		include $this->view;
	}

	function error() {
		
	}
}