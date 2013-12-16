<?php
	/**
	 * Handles Queries as objects to keep from having extensive function
	 * parameters and whatnot in one class. Utilizes PDO.
	 *
	 * @author Mike Mclaren <mike.mclaren@sq1.com>
	 */
	class DBQuery {
		/* The query proper; needs to be a string. */
		private $query;

		/* An array of values that are going to get executed in the PDO query. */
		private $values;

		/* The base table. */
		private $table;

		/* The base query type; SELECT, UPDATE, etc. */
		private $baseQueryType;

		/* The PDO DB connection. */
		private static $db;

		private $where = false;

		public function __construct($table) {
			$this->table = $table;

			// Initializes the DB only if it doesn't already exist.
			// Since DB is only ever called in DBQuery, this is a 
			// localized Singleton, I guess?
			if(self::$db == NULL)
				self::$db = new PDODB();
		}

		/**
		 * Builds a select query, given an array of values.
		 * @param  array   $values An array of values
		 * @return DBQuery         The DBQuery object being affected
		 */
		public function select($values = array('*')) {
			if(isset($this->baseQueryType) && $this->baseQueryType != '')
				return false;

			if(!is_array($values))
				return false;

			$this->baseQueryType = 'SELECT';

			$this->query = 'SELECT ';
			foreach($values as $key => $val) {
				if($key != 0)
					$this->query .= ', ';

				$this->query .= $val;
			}
			$this->query .= ' FROM '.$this->table;

			return $this;
		}

		/**
		 * Builds an update query on a set of given values.
		 * @param  array  $values An associate array of values, with the keys
		 *                        being columns and the values being the values
		 *                        for the columns to be changed to. 
		 * @return DBQuery        The DBQuery object being affected
		 */
		public function update($values) {
			if(isset($this->baseQueryType) && $this->baseQueryType != '')
				return false;

			if(!is_array($values))
				return false;

			$this->baseQueryType = 'UPDATE';

			$this->query = 'UPDATE '.$this->table.' SET ';
			$index = 0;
			foreach($values as $key => $val) {
				if($index != 0)
					$this->query .= ', ';

				$this->query .= $key . ' = ' . '?';
				$this->values[] = $val;
				$index++;
			}

			return $this;
		}

		/**
		 * Builds a delete query for the current table.
		 * @return DBQuery       The DBQuery object being affected
		 */
		public function delete() {
			if(isset($this->baseQueryType) && $this->baseQueryType != '')
				return false;

			$this->baseQueryType = 'DELETE';
			$this->query = 'DELETE FROM '.$this->table;

			return $this;
		}

		/**
		 * Builds an insert query based on a set of given values.
		 * @param  array $columns An array of column names; this designates the
		 *                        order in which <b>$values</b> is used.
		 * @param  array $values  A nested array of value items. Each top-level
		 *                        array is a row, and each element in that array
		 *                        is a column value being inserted.
		 * @return DBQuery        The DBQuery object being affected
		 */
		public function insert($columns, $values) {
			if(isset($this->baseQueryType) && $this->baseQueryType != '')
				return false;

			$this->baseQueryType = 'INSERT';
			$this->query = 'INSERT INTO '.$this->table.' ( '.implode(', ',$columns).' ) VALUES';
			foreach($values as $row => $vals) {
				$this->query .= ' ( '; 
				foreach($vals as $key => $v) {
					if($key != 0)
						$this->query .= ', ';
					
					$this->query   .= '?';
					$this->values[] = $v;
				}
				$this->query .= ' )';
			}

			return $this;
		}

		/**
		 * Builds a join onto the DBQuery.
		 * @param  string $table The table being joined
		 * @param  string $type  The type of join being cast; optional
		 * @return DBQuery       The DBQuery object being affected
		 */
		public function join($table, $type = '') {
			if(!isset($this->baseQueryType) || $this->baseQueryType == '')
				return false;

			$this->join         = true;

			if($type == '')
				$this->query .= ' INNER JOIN';

			$this->query .= ' ' . $table;

			return $this;
		}

		public function on($column, $operand = '', $value = '') {
			if(!isset($this->baseQueryType) || $this->baseQueryType == '')
				return false;

			if(!$this->join)
				return false;

			$this->query .= ' ON ' . $column;
			if($operand != '' && $value != '')
				$this->query .= ' ' . $operand . ' '.$value;

			return $this;
		}

		/**
		 * Tacks a WHERE statement onto the DBQuery.
		 * @param  string $column  The column to be checked against
		 * @param  string $operand The SQL compliant operand to use to check
		 * @param  string $value   The value to be checked
		 * @return DBQuery         The DBQuery object being affected
		 */
		public function where($column, $operand, $value) {
			if(!isset($this->baseQueryType) || $this->baseQueryType == '')
				return false;
			
			$this->where    = true;
			$this->query   .= ' WHERE ' . $column . ' ' . $operand . ' ?';
			$this->values[] = $value;

			return $this;
		}

		/**
		 * Tacks an OR statement onto the DBQuery.
		 * @param  string $column  The column to be checked against
		 * @param  string $operand The SQL compliant operand to use to check
		 * @param  string $value   The value to be checked
		 * @return DBQuery         The DBQuery object being affected
		 */
		public function _or($column, $operand, $value) {
			if(!$this->where && !$this->join)
				return false;

			$this->query   .= ' OR ' . $column . ' ' . $operand . ' ?';
			$this->values[] = $value;

			return $this;
		}

		/**
		 * Tacks an AND statement onto the DBQuery.
		 * @param  string $column  The column to be checked against
		 * @param  string $operand The SQL compliant operand to use to check
		 * @param  string $value   The value to be checked
		 * @return DBQuery         The DBQuery object being affected
		 */
		public function _and($column, $operand, $value) {
			if(!$this->where && !$this->join)
				return false;

			$this->query   .= ' AND ' . $column . ' ' . $operand . ' ?';
			$this->values[] = $value;

			return $this;
		}

		/**
		 * Tacks an OrderBy statement onto the DBQuery.
		 * @param  string $column    The column to order by
		 * @param  string $ascOrDesc The ascending or descending parameter
		 * @return DBQuery           The DBQuery object being affected
		 */
		public function orderBy($column, $ascOrDesc='ASC') {
			if(!isset($this->baseQueryType) || $this->baseQueryType == '')
				return false;

			$this->query .= ' ORDER BY '.$column.' '.$ascOrDesc;

			return $this;
		}

		public function limit($int) {
			if(!isset($this->baseQueryType) || $this->baseQueryType == '')
				return false;

			if(!is_numeric($int) || $int <= 0)
				return false;

			$this->query .= ' LIMIT '.$int;
			return $this;
		}

		/**
		 * Executes the current built query based on defined Database
		 * Settings.
		 * @return DBResults   The results of the database query.
		 */
		public function execute() {
			if(!isset($this->query) || $this->query == '')
				return false;

			self::$db->prepareQuery($this->query);
			$results = self::$db->executeQuery($this->values);
			return $results;
		}

		/**
		 * Returns the current query.
		 * @return string The current query string
		 */
		public function getQuery() {
			return $this->query;
		}

		/**
		 * Resets the query object to its default state; retains the Table definition,
		 * unless <b>$table</b> is passed.
		 * @param  string  $table Optional; The table the DBQuery should query against.
		 * @return DBQuery        The DBQuery object being affected
		 */
		public function reset($table = NULL) {
			if($table != NULL)
				$this->table = $table;
			
			$this->query         = NULL;
			$this->values        = NULL;
			$this->baseQueryType = NULL;
		}
	}