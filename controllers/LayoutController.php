<?php
	class LayoutController extends Controller {
		public function __construct() {
			parent::__construct();
		}

		public function header($meta) {
			if(!ASYNC) include TEMPLATE_PATH.'header.php';
		}

		public function footer() {
			if(!ASYNC) include TEMPLATE_PATH.'footer.php';			
		}
	}