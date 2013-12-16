<?php
	/**
	 * Handles the results of PDO DB Queries. Always associative,
	 * satisfaction guarenteed!
	 *
	 * @author Mike Mclaren <mike.mclaren@sq1.com>
	 */
	class DBResults {
		private $raw;
		private $results = array();

		public function __construct($results) {
			$this->raw = $results;
			try {
				$this->buildResults();
			} catch(Exception $e) {
				throw $e;
			}
		}

		private function buildResults() {
			try {
				while($r = $this->raw->fetch(PDO::FETCH_ASSOC)) {
					$this->results[] = $r;
				}
			} catch(Exception $e) {
				throw $e;
			}
		}

		/**
		 * Returns an array of results from
		 * a query.
		 * @return array A list of results, ASSOC ARRAYED.
		 */
		public function returnResults() {
			return $this->results;
		}

		/**
		 * Builds models based on the returned array.
		 * @param  string $className The class name of the objects to
		 *                           be built.
		 * @return mixed             The constructed objects.
		 */
		public function buildModels($className) {
			$objects = array();
			foreach($this->results as $r) {
				$o = new $className();
				foreach($r as $key => $value) {
					$o->$key = $value;
				}
				$objects[] = $o;
			}

			return $objects;
		}

		/**
		 * Builds an object based on results. Say now,
		 * say.
		 * @param  string $object The object to build onto.
		 * @param  array  $result If passed, will use the result array
		 *                        as the basis for building.
		 */
		public function buildObject(&$object, $result = null) {
			if($result) {
				foreach($result as $key => $value) {
					$object->$key = $value;
				}
			} else {
				foreach($this->results as $res) {
					foreach($res as $key => $value) {
						$object->$key = $value;
					}
				}
			}

			return $object;
		}
	}