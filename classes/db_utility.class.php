<?php
/**
 *	DBUtility - Utility class
 *
 *	@description	Handles DB connections, queries, and functions
 */

Class DB_Utility extends Utility {
	//-----> Global Variables (private: not inherited, protected: inhereted)
    protected $error_output = FALSE;
    private $_hostname;
    private $_username;
    private $_password;
    private $_database;
    protected $dbsvr;
    public $connected;
    
	//-----> Connect to DB on Class initiation
	public function __construct() {
		$this->_hostname = DB_HOST;
		$this->_username = DB_USER;
		$this->_password = DB_PASSWORD;
		$this->_database = DB_NAME;
		
		$this->dbsvr = mysql_connect($this->_hostname, $this->_username, $this->_password);
		$this->connected = (!$this->dbsvr) ? FALSE : TRUE;
		mysql_select_db($this->_database, $this->dbsvr);
	}
	
	//-----> Prepare and run SELECT query
	protected function qSelect($table, $values='*', $conditions='', $database='') {
		// switch DB if one provided
		if($database!='') { mysql_select_db($database, $this->dbsvr); }
		
		// validate table
		if($table=='') { return $this->sendError('There was no $table defined for ' . __FUNCTION__); }
		
		// build query
		$query = 'SELECT '.$values.' FROM '.$table.' '.$conditions.';';

		// run update query
		$result = $this->runQuery($query);
		$num_rows = mysql_num_rows($result);
		
		return ($num_rows > 0) ? $result : FALSE;
	}
	
	//-----> Prepare and run SELECT query (@return: int - mysql_num_rows)
	protected function qSelectNumRows($table, $values='*', $conditions='', $database='') {
		// switch DB if one provided
		if($database!='') { mysql_select_db($database, $this->dbsvr); }
		
		// validate table
		if($table=='') { return $this->sendError('There was no $table defined for ' . __FUNCTION__); }
		
		// build query
		$query = 'SELECT '.$values.' FROM '.$table.' '.$conditions.';';

		// run update query
		$result = $this->runQuery($query);
		$num_rows = mysql_num_rows($result);
		
		return ($num_rows > 0) ? $num_rows : FALSE;
	}

	//-----> Prepare and run DELETE query (@return: boolean)
	protected function qDelete($table, $conditions='', $database='') {
		// switch DB if one provided
		if($database!='') { mysql_select_db($database, $this->dbsvr); }
		
		// validate table
		if($table=='') { return $this->sendError('There was no $table defined for ' . __FUNCTION__); }
		
		// build query
		$query = 'DELETE FROM '.$table.' '.$conditions.';';

		// run update query
		return $this->runQuery($query);
	}
	
	//-----> Prepare and run INSERT query (NOTE: if is_array($values) => query sets key=value, @return: boolean)
	protected function qInsert($table, $values, $conditions='', $database='') {
		// switch DB if one provided
		if($database!='') { mysql_select_db($database, $this->dbsvr); }

		// validate table
		if($table=='') { return $this->sendError('There was no $table defined for ' . __FUNCTION__); }
		
		// build query
		$query = 'INSERT INTO `'.$table.'` SET ';
		if(is_array($values)) {
			$n=1;
			foreach ($values as $field => $value) {
				$query .= "`$field`='".mysql_real_escape_string($value)."'";
				$query .= ($n==count($values)) ? " " : ", ";
				$n++;
			}
		} else if(is_string($values) && $values!='') {
			$query .= $values;
		} else { return $this->sendError('There is an error with the values sent to ' . __FUNCTION__); }
		$query .= $conditions . ';';

		// run update query
		return $this->runQuery($query);
	}

	//-----> Prepare and run UPDATE query (NOTE: if is_array($values) => query sets key=value, @return: boolean)
	protected function qUpdate($table, $values, $conditions='', $database='') {
		// switch DB if one provided
		if($database!='') { mysql_select_db($database, $this->dbsvr); }
		
		// validate table
		if($table=='') { return $this->sendError('There was no $table defined for ' . __FUNCTION__); }
		
		// build query
		$query = 'UPDATE `'.$table.'` SET ';
		if(is_array($values)) {
			$n=1;
			foreach ($values as $field => $value) {
				$query .= "`$field`='".mysql_real_escape_string($value)."'";
				$query .= ($n==count($values)) ? " " : ", ";
				$n++;
			}
		} else if(is_string($values) && $values!='') {
			$query .= $values;
		} else { return $this->sendError('There is an error with the values sent to ' . __FUNCTION__); }
		$query .= ' ' . $conditions . ';';

		// run update query
		return $this->runQuery($query);
	}
	
	//-----> Execute query (@return: resource for SELECT, boolean for INSERT/UPDATE/DELETE)
	protected function runQuery($query) { 
		$result = mysql_query($query, $this->dbsvr) or $this->sendError($query . '<br class="clear" />' . mysql_error());
		return $result;
	}
	
	//-----> send ERROR and SUCCESS message to browser
	protected function sendError($message) { 
		if($this->error_output) { echo '<p class="error">',$message,'</p>'."\n"; }
		return FALSE;
	}
	protected function sendMessage($message) { 
		if($this->error_output) { echo '<p class="message">',$message,'</p>'."\n"; }
		return TRUE;
	}
} // end DBUtility
