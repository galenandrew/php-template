<?php
/**
 * This is where all the routing actually happens now. The addition of routes can technically be done
 * anywhere after the primary Router is called, but let's try and keep it all in config/routes.php, as
 * that's where things were prior to this change. Also, this uses regex for route matching, hooray!
 *
 * @author Mike Mclaren <mike.mclaren@sq1.com>
 **/

class Router {
	private $routes;
	public  $url;

	private $params;

	private $patterns = array(
		'/\[\(a\):[a-zA-Z0-9\_\-]+\]/',                            // [(a):param]
		'/\[\(a\+\):[a-zA-Z0-9\_\-]+\]/',                          // [(a+):param]
		'/\[\(i\):[a-zA-Z0-9\_\-]+\]/',                            // [(i):param]
		'/\[\(a\_\):[a-zA-Z0-9\_\-]+\]/',                          // [(a_):param]
		'/\[\(a\_\+\):[a-zA-Z0-9\_\-]+\]/',                        // [(a_+):param]
		'/\[:[a-zA-Z0-9\_\-]+\]/',                                 // [:param]
		'/\[:[a-zA-Z0-9\_\-]+=(\(([a-zA-Z0-9\_\-]+\|?)+\))\]/',    // [:param=(this|that)]
//			'/\[(\(([a-zA-Z0-9\_\-]+\|?)+\))\]/',                      // [(this|that)]
		'/\[:[a-zA-Z0-9\_\-]+!=(([a-zA-Z0-9\_\-]+)+)\]/'           // [:param!=this]
	);

	private $replacements = array(
		'([a-zA-Z]+)',                                             // [(a):param]
		'([a-zA-Z0-9]+)',                                          // [(a+):param]
		'([0-9]+)',                                                // [(i):param]
		'([a-zA-Z\_\-]+)',                                         // [(a_):param]
		'([a-zA-Z0-9\_\-]+)',                                      // [(a_+):param]
		'([a-zA-Z0-9\_\-]+)',                                      // [:param]
		'$1',                                                      // [:param=(this|that)]
//			'$1',                                                      // [(this|that)]
		'(?!$1)'                                                   // [:param!=this]
	);

	private $get;
	private $post;

	private $layout;

	public $controller;
	private $method;
	private $method_var;

	private $matches;

	public function __construct() {
		$this->routes = array();
		$this->layout = new LayoutController();
		$this->getURLParameters();

		$this->getRoutes();

		$this->matches = $this->matchRoutes();
	}

	private function getRoutes() {
		include_once(CONFIG_PATH.'routes.php');
		if(count($routes) > 0) {
			foreach($routes as $route) {
				$this->addRoute($route[0], $route[1], $route[2]);
			}
		}
	}
	
	private function addRoute($route, $controller, $method = NULL) {
		array_push($this->routes, array('route' => $route, 'controller' => $controller, 'callback' => $method));
	}
	
	private function matchRoutes() {
		// First, check for overwrites.
		foreach($this->routes as $route) {
			// Replace all :tags with the proper REGEX.
			$pattern = "@^" . preg_replace($this->patterns, $this->replacements, str_replace('/', '\/', $route['route'])) . "$@D";
			$matches = array();
			if(preg_match($pattern, $this->url, $matches)) {
				array_shift($matches);
				// Now we're going to go through the route and pull out the id and match things up, hopefully.
				$params = array();
				$p = array();

				if(preg_match_all('/\:[a-zA-Z0-9\_\-]+/', $route['route'], $params)) {
					$params = $params[0];
					for($i = 0; $i < count($params); $i++) {
						$p[str_replace(':', '', $params[$i])] = $matches[$i];
					}
				}

				$controllerName = $route['controller'] . 'Controller';
				$method     	= $route['callback'];
				$controllerFile = CONTROLLERS . ucwords($controllerName) . '.php';
				if(file_exists($controllerFile)) {
					$controller = new $controllerName();

					if(method_exists($controller, $method)) {
			 			$this->controller = $controller;
			 			$this->method     = $method;
			 			$this->method_var = $p;
			 			$this->controller->$method($this->method_var);
			 			return true;
			 		} else
			 			return false;
			 	}
			}
		}

		return false;
	}

	private function getURLParameters() {
		if(substr(REQ, -1) == '/')
    		$this->url = '/' . substr(REQ, 0, -1);
		else
			$this->url = '/' . REQ;

		$this->params = explode('/', REQ);
		$this->get    = $_GET;
		$this->post   = $_POST;
	}

	public function route() {
		// If no overwrites match, then we go to first fallback, which is: Controller / Page (OR Index, if no Page is defined.
		if(!$this->matches) {
			// Actually, let's make sure there are parameters. If not, we'll toss to pages/index.php
			if(!isset($this->params[0]) || $this->params[0] == '') {
				require PAGES . 'home.php';
				return true;
			}
 			
			$controllerRequest = $this->params[0] . 'Controller';
			$controllerFile    = CONTROLLERS . ucwords($controllerRequest) . '.php';
			if(file_exists($controllerFile)) {
				$controller = new $controllerRequest();
				if(isset($this->params[1])) {
					$method = $this->params[1];
					if(method_exists($controller, $method))
						return $controller->$method($this->params);
					else
						return $controller->error();
				}

				return $controller->index();
			}

			// If that doesn't exist, then it does a Page with an optional Kinda-Controller. This is the OLD way of doing things,
			// spruced up a bit. (But still, if it gets here, you're kind of a Grandpa. Or the page is static. Whatevs.)
			$page = PAGES . $this->params[0] . '.php';
			if(!file_exists($page)) {
				if(file_exists(ERROR_404_CONTROLLER))
					include(ERROR_404_CONTROLLER);

				require(ERROR_404_PAGE);
				return false;
			} else {
				$controller = CONTROLLERS . $this->params[0] . '.php';
				if(file_exists($controller))
					include $controller;

				if(!defined('IS_404') || !IS_404) {
					require $page;
					return true;
				} else {
					if(file_exists(ERROR_404_CONTROLLER))
						include(ERROR_404_CONTROLLER);

					require(ERROR_404_PAGE);
					return false;
				}
			}
		} else {
			$this->controller->execute();
		}
	}
}