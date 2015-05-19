<?php

class PC_Db_pdo extends PC_Db {
	private $_con;
	private $_result;
	private $_config;
	private $_stmt;
	private $_sth;
	private $_sql;
	private $_driver;
	
	const MYSQL = 'mysql';
	const SQLITE = 'sqlite';
	const PGSQL = 'pgsql';

	function __construct() {
	}

	function connect() {
	    $c = PC_Config::get('database', PC_Config::get('db_no'));
		$this->_config = $c;

		$this->_driver = $c['db_driver'];

		if ($c['db_driver'] != self::MYSQL && 
			$c['db_driver'] != self::SQLITE &&
			$c['db_driver'] != self::PGSQL) {
			PC_Abort::abort('Connect Error, not fount driver:' . $c['db_driver']);
		}

		try {
		    if ($c['db_driver'] == self::MYSQL) {
				$dsn = $c['db_driver'] . ':host=' . $c['db_host'] . ';dbname=' . $c['db_name'];
				$user = $c['db_user'];
				$pass = $c['db_pass'];
				$options = array(
					 PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					 ); 
				$this->_con = new PDO($dsn, $user, $pass, $options);
		    } else if ($c['db_driver'] == self::PGSQL) {
				$dsn = $c['db_driver'] . ':host=' . $c['db_host'] . ';dbname=' . $c['db_name'];
				$user = $c['db_user'];
				$pass = $c['db_pass'];
				$options = array(
					 //PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
					 ); 
				$this->_con = new PDO($dsn, $user, $pass, $options);
		    } else if ($c['db_driver'] == self::SQLITE) {
		    	if (preg_match('%/%', $c['db_name'])) {
					$db_file = $c['db_name'];
		    	} else {
					$db_file = PUMPCMS_APP_PATH . '/db/' . $c['db_name'];
				}
				if (is_writeable($db_file) == false) {
					PC_Abort::abort("sqlite:Don't write db file");
				}
				$db_dir = dirname($db_file);
				if (is_writeable($db_dir) == false) {
					PC_Abort::abort("sqlite:Don't write db dir");
				}
				$dsn = 'sqlite:' . $db_file;
				$this->_con = new PDO($dsn);
		    } else {
		    	throw new Exception('No driver');
		    }
		} catch (Exception $e) {
			PC_Abort::abort('Connect Error (' . $e->getMessage() . ') ');
		}
	}

	function get_driver() {
		return $this->_config['db_driver'];
	}
	
	function prefix($table) {
		return $this->_config['db_prefix'] . '_' . $table;
	}
	
	function close() {
		//$this->_con->close();
	}
	
	function prepare($sql) {
		PC_Debug::log($sql, __FILE__, __LINE__);

		try {
			$this->_stmt = $this->_con->prepare($sql);
		} catch (Exception $e) {
			$this->abort($sql);
		}

		if ($this->_stmt == false) {
			$this->abort($sql, __FILE__ . ':' . __LINE__ . ' ' . print_r($this->_con->errorCode(), true) . ':' . print_r($this->_con->errorInfo(), true));
		}

		return $this->_stmt;
	}

	function beginTransaction() {
		try {
			$ret = $this->_con->beginTransaction();
			if ($ret == false) {
				$this->abort();
			}
		} catch (Exception $e) {
			$this->abort();
		}
	}

	function commit() {
		try {
			$ret = $this->_con->commit();
			if ($ret == false) {
				$this->abort();
			}
		} catch (Exception $e) {
			$this->abort();
		}
	}

	function query($sql, $values=array(), $types=array()) {
		PC_Debug::log($sql, __FILE__, __LINE__);
		
		try {
			$this->_sql = $sql;

			$this->_stmt = $this->_con->prepare($sql);
			$result = $this->_stmt->execute($values);
		} catch (Exception $e) {
			$this->abort($sql);
		}

		if ($result == false ) {
			$this->abort($sql);
		}
	}

	function exec($sql, $values, $types) {
		PC_Debug::log('sql:' . $sql, __FILE__, __LINE__);
		PC_Debug::log('values:' . print_r($values, true), __FILE__, __LINE__);
		PC_Debug::log('types:' . print_r($types, true), __FILE__, __LINE__);
		
		$sth = $this->_con->prepare($sql);

		foreach ($values as $key => $value) {
			$type = PC_Db::T_STRING;
			if ($types[$key] == PC_Db::T_INT) {
				$type = PDO::PARAM_INT;
			} else if($types[$key] == PC_Db::T_STRING) {
				$type = PDO::PARAM_STR;
			} else if($types[$key] == PC_Db::T_BLOB) {
				$type = PDO::PARAM_LOB;
			}
			$sth->bindParam($key, $value, $type);
		}

		$ret = $sth->execute($values);	
		if ($ret == false) {
		    $tmp = $sth->errorInfo();
		    $this->abort($sql, $tmp[2]);
		}
	}

	function fetch_row($sql) {
		$this->query($sql);

		$row = $this->_stmt->fetch(PDO::FETCH_ASSOC);
		
		//$this->_result->close();

		return $row;
		
	}
	
	function fetch_assoc($sql, $values=array(), $types=array()) {
		$this->query($sql, $values, $types);
		
		$this->_sql = $sql;

		$list = array();
		while ($row = $this->_stmt->fetch(PDO::FETCH_ASSOC)) {
			if ($row == false) {
				$this->abort();
			}
			array_push($list, $row);
		}
		
		//$this->_result->close();

		return $list;
	}
	
    function insert_id($sequence_obj_name='') {
	    $id = $this->_con->lastInsertId($sequence_obj_name);
	    return $id;
	}
    
    function escape($str) {
		return $this->_con->quote($str);
	}

    function column_escape($str) {
		$s = $this->_con->quote($str);
		$s = substr($s, 1);
		$s = substr($s, 0, -1);
		if ($this->get_driver() == self::PGSQL) {
			return '"' . $s . '"';
		} else {
			return '`' . $s . '`';
		}
	}

	public function is_sqlite() {
		if ($this->_driver == self::SQLITE) {
			return true;
		}

		return false;
	}

	function abort($sql='', $err='') {
	    $str = 'Query Error (' . @$this->_con->errno . ') ' . @$this->_con->error;

	    if (UserInfo::is_master_admin()) {
			$str .= ' ' . $this->_sql . ' ' . $sql;
			$str .= ' err:' . $err . ' ';

			PC_Debug::log('err:' . $str, __FILE__, __LINE__);
			PC_Debug::log(print_r(debug_backtrace(), true), __FILE__, __LINE__);
	    }
	    PC_Abort::abort();
	}
}