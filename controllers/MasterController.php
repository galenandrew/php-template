<?php
	class MasterController {
		private $layout;
		private $router;

		public function __construct() {
			$this->layout = new LayoutController();
			$this->router = new Router();

			$this->view();
		}

		public function view() {
			//$this->getSEOMetaData();
			$this->layout->header($this->meta);
			$this->router->route();
			$this->layout->footer();
		}

		private function getSEOMetaData() {
			$db  = new DB(null);
			$seo = $db->select('seo_meta', 
				array('url', 'titles', 'keywords', 'description'),
				array(
					'WHERE' => array(
									array('url', '=', $this->router->url)
									)
					),
				null,
				false
			);

			$this->meta = array();
			if(isset($seo[0])) {
				$this->meta['title']       = $seo[0]['titles'];
				$this->meta['description'] = $seo[0]['description'];
			}

			if(isset($this->router->controller)) {
				if(get_class($this->router->controller) == 'ProductController') {
					$product = $this->router->controller->model;

					if(isset($this->meta['title']))
						$this->meta['title']       = str_replace('MODEL NUMBER', $product->name, $this->meta['title']);
					
					if(isset($this->meta['description']))
						$this->meta['description'] = str_replace('MODEL NUMBER', $product->name, $this->meta['description']);
				}
			}
		}
	}