<?php

class PC_Db_mysql extends PC_Db {
	private $_con;
	private $_result;
	private $_config;
	
	function __construct() {
	}
	
	function connect() {

	        $c = PC_Config::get('database', PC_Config::get('db_no'));
		$this->_config = $c;

		$this->_con = new mysqli($c['db_host'],
								$c['db_user'],
								$c['db_pass'],
								$c['db_name']);
								
		if ($this->_con->connect_error) {
			PC_Abort::abort('Connect Error (' . $this->_con->connect_errno . ') ' . $this->_con->connect_error);
		}
	    
	    $this->_con->set_charset('utf8');
	}
	
	function prefix($table) {
		return $this->_config['db_prefix'] . '_' . $table;
	}
	
	function close() {
		$this->_con->close();
	}
	/*
	function query($sql) {
		PC_Debug::log($sql, __FILE__, __LINE__);
		
		$this->_result = $this->_con->query($sql, MYSQLI_USE_RESULT);

		if ($this->_result == false) {
			$str = 'Query Error (' . $this->_con->errno . ') ' . $this->_con->error;
			if (UserInfo::is_master_admin()) {
				$str .= ' SQL:' . $sql;
			}
			PC_Abort::abort($str);
		}

	}
*/
	function query($sql, $values=array(), $types=array()) {
		PC_Debug::log($sql, __FILE__, __LINE__);

		$sql = preg_replace('/:p\d\d?/', '?', $sql);
		
		$stmt = $this->_con->prepare($sql);

		if ($stmt == false) {
			$str = 'Query Error (' . $this->_con->errno . ') ' . $this->_con->error;
			if (UserInfo::is_master_admin()) {
				$str .= ' SQL:' . $sql;
			}
			PC_Abort::abort($str);
		}

		$t = '';
		$v = array();
		foreach ($values as $key => $value) {
			$t .= $types[$key];
			array_push($v, $value);
		}
		//$stmt->bind_param($t, $v);
		$p = array_merge(array($t), $v);
		if (0 < count($values)) {
			call_user_func_array(array($stmt, 'bind_param'), PC_Util::ref_values($p));
		}

		$ret = $stmt->execute();
		if ($ret == false) {
			$str = 'Query Error (' . $this->_con->errno . ') ' . $this->_con->error;
			if (UserInfo::is_master_admin()) {
				$str .= ' SQL:' . $sql;
			}
			PC_Abort::abort($str);
		}

		$this->_result = $stmt->get_result();

		//$stmt->close();

	}

	function exec($sql, $values, $types) {
		PC_Debug::log($sql, __FILE__, __LINE__);

		$sql = preg_replace('/:p\d\d?/', '?', $sql);

		$stmt = $this->_con->prepare($sql);

		if ($stmt == false) {
			$str = 'Query Error (' . $this->_con->errno . ') ' . $this->_con->error;
			if (UserInfo::is_master_admin()) {
				$str .= ' SQL:' . $sql;
			}
			PC_Abort::abort($str);
		}

		$t = '';
		$v = array();
		foreach ($values as $key => $value) {
			$t .= $types[$key];
			array_push($v, $value);
		}
		//$stmt->bind_param($t, $v);
		$p = array_merge(array($t), $v);
		call_user_func_array(array($stmt, 'bind_param'), PC_Util::ref_values($p));

		$ret = $stmt->execute();
		if ($ret == false) {
			$str = 'Query Error (' . $this->_con->errno . ') ' . $this->_con->error;
			if (UserInfo::is_master_admin()) {
				$str .= ' SQL:' . $sql;
			}
			PC_Abort::abort($str);
		}

		$stmt->close();
	}

	function execute_with_upload($sql, $upload) {
	    echo " sql : $sql ";
	    $stmt = $this->_con->prepare($sql);

	    if ($stmt == false) {
		PC_Abort::abort('Query Error (' . $this->_con->errno . ') ' . $this->_con->error);
	    }
	    /*
	    $null = NULL;
	    $stmt->bind_param('b', $null);
	    $fp = fopen($_FILES[$upload]['tmp_name'], 'r');
	    while (! feof($fp)) {
		$stmt->send_long_data(0, fread($fp, 8192));
	    }
	    fclose($fp);
	     * */
	    $s = 'hello';
	    $stmt->bind_param('b', $s);
	    
	    $this->_result = $stmt->execute();

	    if ($this->_result == false) {
	    	$str = 'Query Error (' . $this->_con->errno . ') ' . $this->_con->error;
	    	if (UserInfo::is_master_admin()) {
	    		$str . ' ' . $sql;
	    	}
			PC_Abort::abort($str);
	    }

	}
	
	function fetch_row($sql, $values=array(), $types=array()) {
		$this->query($sql, $values, $types);

		$row = $this->_result->fetch_assoc();
		
		$this->_result->close();

		return $row;
		
	}
	
	function fetch_assoc($sql, $values=array(), $types=array()) {
		$this->query($sql, $values, $types);
		
		$list = array();
		while ($row = $this->_result->fetch_assoc()) {
			array_push($list, $row);
		}
		
		$this->_result->close();

		return $list;
		
	}
	
    function insert_id() {
	    return $this->_con->insert_id;
	}
    
    function escape($str) {
		return "'" . $this->_con->real_escape_string($str) . "'"; 
	}
}

