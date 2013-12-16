<?php
	class LayoutController extends Controller {
		public function __construct() {
			parent::__construct();
		}

		public function header($meta) {
			$this->meta = $meta;
			$residential = new Type('residential');
			$commercial  = new Type('commercial');
			$categories  = array('residential' => $residential->Categories, 'commercial' => $commercial->Categories);
						
			if(!ASYNC) include TEMPLATE_PATH.'header.php';
		}

		public function footer() {
			if(!ASYNC) include TEMPLATE_PATH.'footer.php';			
		}
	}