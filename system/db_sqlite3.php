<?php

class PC_Db_sqlite3 extends PC_Db {
	private $_con;
	private $_result;
	private $_config;
	
	function __construct() {
	}
	
	function connect() {
	    $c = PC_Config::get('database', PC_Config::get('db_no'));
		$this->_config = $c;
	    $path = PUMPCMS_APP_PATH . '/db/' .  $c['db_name'];
		$this->_con = new SQLite3($path);
		
	}
	
	function prefix($table) {
		return $this->_config['db_prefix'] . '_' . $table;
	}
	
	function close() {
		$this->_con->close();
	}
	
	function query($sql) {
	        if (preg_match('/^\s*select /i', $sql)) {
		$this->_result = $this->_con->query($sql);
		} else {
		$this->_result = $this->_con->exec($sql);
		}
	
		if ($this->_result == false) {
			PC_Abort::abort('Sql Error:query()' . $sql);
		}
		
	}
	
	function fetch_row($sql) {
		$this->query($sql);
		
		$row = $this->_result->fetchArray(SQLITE3_ASSOC);
		
		$this->_result->finalize();
		
		return $row;
		
	}
	
	function fetch_assoc($sql) {
		$this->query($sql);

		$list = array();
		while ($row = $this->_result->fetchArray(SQLITE3_ASSOC) ) {
			array_push($list, $row);
		}
		
		$this->_result->finalize();

		return $list;
	}

         function insert_id() {
	     return $this->_con->lastInsertRowID();
	 }
    
	function escape($str) {
	
		return $this->_con->escapeString($str);
	}
}

