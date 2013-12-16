<?php
	/**
	 * Handles DB calls; this DB utility uses PDO and connects to a 
	 * SQL database.
	 *
	 * @author Mike Mclaren <mike.mclaren@sq1.com>
	 */
	class PDODB {
		/* The PDO object. */
		private $pdo;

		private $driver = 'mysql';

		private $statement;

		public function __construct() {
			try {
				$this->connect();
			} catch(Exception $e) {
				throw $e;
			}
		}

		private function connect() {
			try {
				$this->pdo = new PDO(
					$this->driver.':host='.DB_HOST.';dbname='.DB_NAME, 
					DB_USER, 
					DB_PASSWORD
				);

				$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			} catch(PDOException $e) {
				throw $e;
			}
		}

		/**
		 * Prepares a query for execution in PDO.
		 * @param  string $query The query to prepare.
		 */
		public function prepareQuery($query) {
			try {
				$this->statement = $this->pdo->prepare($query);
			} catch(Exception $e) {
				throw $e;
			}
		}

		/**
		 * Executes an already prepared query for use
		 * in PDO.
		 * @param  array  $values   The parameter values to use with PDO
		 * @return DBResults        The returned query results.
		 */
		public function executeQuery($values = array()) {
			try {
				if(!isset($this->statement))
					throw new Exception();

				$this->statement->execute($values);
				$db_results = new DBResults($this->statement);
				return $db_results;
			} catch(Exception $e) {
				throw $e;
			}
		}
	}