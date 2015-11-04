<?php

require_once PUMPCMS_SYSTEM_PATH . '/pumpimage.php';
require_once PUMPCMS_SYSTEM_PATH . '/pumpfile.php';

class PumpORMAP {
    var $form_config;
    private $_row_count = 0;
    
	static $_ormap = array();

    public function __construct($form_data) {
		$this->form_config = $this->normalization($form_data);
    }

    private function normalization($form_data) {
    	$column_list = $form_data['column'];
    	$map = array();
    	foreach ($column_list as $key => $value) {
    		$map[$value['name']] = 1;
    	}

    	if (isset($map['id']) == false) {
    		$c = 
    		array('name' => 'id',
			      'type' => PUMPFORM_PRIMARY_ID,
			      'visible' => 0,
			      'list_visible' => 0);
    		$column_list = array_merge($c, $column_list);
    	}

    	if (isset($map['site_id']) == false) {
        	$column_list['site_id'] = 
        		array('name' => 'site_id',
           		   'type' => PUMPFORM_SITE_ID,
           		   'visible' => 0);
    	}

    	if (isset($map['reg_time']) == false) {
        	$column_list['reg_time'] = 
    	        array('name' => 'reg_time',
	              'type' => PUMPFORM_TIME,
	              'visible' => 0,
	              'list_visible' => 0);
		}

    	if (isset($map['mod_time']) == false) {
        	$column_list['mod_time'] = 
    	        array('name' => 'mod_time',
	              'type' => PUMPFORM_TIME,
	              'visible' => 0,
	              'list_visible' => 0);
		}

    	if (isset($map['reg_user']) == false) {
        	$column_list['reg_user'] = 
    	        array('name' => 'reg_user',
	              'type' => PUMPFORM_TIME,
	              'visible' => 0,
	              'list_visible' => 0);
		}

    	if (isset($map['mod_user']) == false) {
        	$column_list['mod_user'] = 
    	        array('name' => 'mod_user',
	              'type' => PUMPFORM_TIME,
	              'visible' => 0,
	              'list_visible' => 0);
		}

		$form_data['column'] = $column_list;

		return $form_data;
    }
    
    public function get_table() {
		return $this->form_config['module'] . '_' . $this->form_config['table'];
    }
    
    public function get($id) {
    	return $this->get_one($id);
    }

    public function get_one($id, $column=null) {
		$db = PC_DBSet::get();

		$table = $this->get_table();
	
		$sql = ' SELECT ';
		if ($column == null) {
			$sql .= ' * ';
		} else {
			$sql .= $column;
		}
		$sql .= ' FROM ' . $db->prefix($table);
		$sql .= ' WHERE id = ' . intval($id);

		return $db->fetch_row($sql);

    }
    
    public function get_list($where='', $offset=0, $limit=10, $sort=null, $re_sort=null) {
		$db = PC_DBSet::get();

		$table = $this->get_table();
	
		$sql = ' SELECT * FROM ' . $db->prefix($table);
	    $sql .= ' WHERE ';
	    $sql .= $db->column_escape('site_id');
	    $sql .= ' = ' . intval(PC_Config::get('site_id'));

		if (is_array($where)) {
			$sql .= ' AND ';
			$sql .= $where['where'];
		} else if ($where != '') {
			$sql .= ' AND ' . $where . ' ';
		}
		if ($sort != null) {
			if (is_array($sort)) {
				$sql .= ' ORDER BY ';
				$column = array();
				foreach ($sort as $k => $v) {
					$c = $v['column'];
					if (@$v['re']) {
						$c .= ' DESC ';
					}
					array_push($column, $c);
				}
				$sql .= implode(', ', $column);
			} else {
			    $sql .= ' ORDER BY ';
		    	$sql .= $db->column_escape($sort);

	    		$params['sort'] = $sort;
		    	if ($re_sort) {
					$sql .= ' DESC ';
			    }
			}
		} else if (@$this->form_config['default_sort']) {

			$s = explode('_', $this->form_config['default_sort']);

			$sql .= ' ORDER BY ';
			//$sql .= '`' . $db->escape($s[1]) . '`';
			$sql .= $db->column_escape($s[1]);

			if ($s[0] == 'd') {
				$sql .= ' DESC ';
			}
		}
		$sql .= ' LIMIT ';
		$sql .= intval($limit);
		$sql .= ' OFFSET ';
		$sql .= intval($offset);

		if (is_array($where)) {
			$values = $where['values'];
			$types = $where['types'];
			return $db->fetch_assoc($sql, $values, $types);
		} else {
			return $db->fetch_assoc($sql);
		}

    }

    public function get_count($where='') {
		$db = PC_DBSet::get();

		$table = $this->get_table();
	
		$sql = ' SELECT count(id) as ';
		$sql .= $db->column_escape('cnt');
		$sql .= ' FROM ' . $db->prefix($table);
		$sql .= ' WHERE ';
		$sql .= $db->column_escape('site_id');
		$sql .= ' = ' . intval(PC_Config::get('site_id'));

		if ($where != '') {
			$sql .= ' AND ' . $where;
		}

		$row = $db->fetch_row($sql);

		return intval($row['cnt']);

    }

    public function insert($post=array()) {
		$db = PC_DBSet::get();

		$table = $this->get_table();

		$form = $this->form_config['column'];

		$multi_checkbox_list = array();


		if (count($post) == 0) {
			$post = $_POST;
		}

		$pumpimage = new PumpImage();
		$pumpfile = new PumpFile();

		$sql = 'INSERT INTO ' . $db->prefix($table) . ' ( ';
		$sql .= ' site_id, reg_time, reg_user, mod_time, mod_user, ';

		$columns = array();
		foreach ($form as $column) {
	    	if (@$column['registable'] != 1) {
				continue;
		    }
			if ($column['type'] == PUMPFORM_MULTI_CHECKBOX) {
	    		continue;
	    	}
		    array_push($columns, $column['name']);
		}
	
		$values = array();
		$types = array();
		$params = array();
		$upload = '';
		$geolocation = false;
		$i = 0;
		foreach ($form as $column) {
			$i++;
			$p = ':p' . $i;
	    	if (@$column['registable'] != 1) {
				continue;
	    	}
	    	if ($column['type'] == PUMPFORM_MULTI_CHECKBOX) {
	    		array_push($multi_checkbox_list, $column);
	    		continue;
	    	}
	    	if ($column['name'] == @$this->form_config['1n_link_id']) {
	    		$values[$p] = intval($_GET[$this->form_config['1n_link_id']]);
	    		$types[$p] = PC_Db::T_INT;
	    		array_push($params, $p);
	    		
	    		continue;
	    	}
	    	if ($column['type'] == PUMPFORM_PASSWORD) {
	    		$password = md5(@$post[$column['name']]);
	    		$values[$p] = $password;
	    		$types[$p] = PC_Db::T_STRING;
	    		array_push($params, $p);
		    } else if ($column['type'] == PUMPFORM_IMAGE) {

				$image_id = $pumpimage->upload($column['name']);
				$values[$p] = $image_id;
				$types[$p] = PC_Db::T_INT;
				array_push($params, $p);

		    } else if ($column['type'] == PUMPFORM_FILE) {
				$file_id = $pumpfile->upload($column['name']);
				$values[$p] = $file_id;
				$types[$p] = PC_Db::T_INT;
				array_push($params, $p);
	    	} else if ($column['type'] == PUMPFORM_CHECKBOX) {
				if (@$post[$column['name']]) {
				    $values[$p] = 1;
				} else {
		    		$values[$p] = 0;
				}
				$types[$p] = PC_Db::T_INT;
				array_push($params, $p);
			} else if ($column['type'] == PUMPFORM_ADDRESS_AND_GMAP) {
				$geolocation = true;
				$values[$p] = @$post[$column['name']];
				$types[$p] = PC_Db::T_STRING;
				array_push($params, $p);
	    	} else if ($column['type'] == PUMPFORM_INT) {
				if (@$post[$column['name']] == '') {
					if (@$column['default']) {
						$values[$p] = $column['default'];
					} else {
						$values[$p] = 0;
					}
				} else {
					$values[$p] = @$post[$column['name']];
				}
				$types[$p] = PC_Db::T_INT;
				array_push($params, $p);
	    	} else {
	    		// integer
				if (@$post[$column['name']] == '') {
					if (@$column['default']) {
						$values[$p] = $column['default'];
					} else {
						$values[$p] = '';
					}
				} else {
					$values[$p] = @$post[$column['name']];
				}
				$types[$p] = PC_Db::T_STRING;
				array_push($params, $p);
		    }
		}

		if ($geolocation && @$post['latlng']) {
		   	preg_match('/\((.+)\)/', @$post['latlng'], $r);
			$v = preg_replace('/ /', '', @$r[1]);

			array_push($columns, 'geolocation');
			array_push($values, $v);
		}

		$tmp_c1 = array();
		foreach ($columns as $tmp_c2) {
			array_push($tmp_c1, $db->column_escape($tmp_c2));
		}
		$c = implode(', ', $tmp_c1);
	
		$sql .= $c . ' ) VALUES ( ';
	
		// site_id
		$sql .= intval(PC_Config::get('site_id')) . ', ';
		// reg_time, reg_user
		$sql .= time() . ' , ' . intval(UserInfo::get_id()) . ', ';
		// mod_time, mod_user
		$sql .= '0, 0, ';

		$c = implode(", ", $params);
		$sql .= $c . ' ) ';

	    $db->exec($sql, $values, $types);

	    $this->_row_count = $db->row_count();

		if ($db->get_driver() == PC_Db_pdo::PGSQL) {
			$insert_id = $db->insert_id($db->prefix($table) . '_id_seq');
		} else {
			$insert_id = $db->insert_id();
		}

		if (0 < count($multi_checkbox_list)) {
			
			foreach ($multi_checkbox_list as $column) {
				$t = $column['option']['link_table'];
				$module = $t['module'];
				$table = $t['table'];
				$ormap = PumpORMAP_Util::getInstance($module, $table);
				$list = $_POST[$column['name']];
				$id1 = $column['option']['link_table']['id1'];
				$id2 = $column['option']['link_table']['id2'];
				foreach ($list as $value) {
					$ormap->insert(array($id1 => $insert_id, $id2 => intval($value)));
				}
			}
		}

		return $insert_id;
    }

    public function update($id, $where='') {
		$db = PC_DBSet::get();

		$table = $this->get_table();

		$form = $this->form_config['column'];

		$pumpimage = new PumpImage();
		$pumpfile = new PumpFile();

		$sql = 'UPDATE ' . $db->prefix($table);
		$sql .= ' SET ';

		$columns = array();
		$params = array();
		$values = array();
		$types = array();
		$i = 0;

		array_push($columns, ' mod_time = ' . time());
		array_push($columns, ' mod_user = ' . UserInfo::get_id());

		foreach ($form as $column) {
		    if (@$column['editable'] == 0) {
				continue;
		    } 

		    if ($column['type'] == PUMPFORM_PASSWORD) {
		    	if (@$_POST[$column['name']] == '') {
		    		continue;
		    	}
		    }

		    $i++;
		    $p = ':p' . $i;
	    
	    	$s = '';

	    	if ($column['type'] == PUMPFORM_PASSWORD) {
	    		$password = md5($_POST[$column['name']]);
	    		$s = ' ' . $db->column_escape($column['name']) . ' = ';
				$values[$p] = $password;
				$s .= $p;
		    } else if ($column['type'] == PUMPFORM_IMAGE) {
		    	if (@$_POST[$column['name'] . '_delete']) {
			    	$s = ' ' . $db->column_escape($column['name']) . ' = ';
			    	$image_id = 0;
					$s .= intval($image_id);
		    	} else {
			    	if (@$_FILES[$column['name']]['name'] == '') {
			    		continue;
			    	}
		    		if (@$_FILES[$column['name']]['name'] != '' &&
		    			@$_FILES[$column['name']]['error'] != UPLOAD_ERR_OK) {
		    			continue;
			    	}

			    	$s = ' `' . $column['name'] . '` = ';
			    	$image_id = $pumpimage->upload($column['name']);
					$s .= intval($image_id);
				}
		    } else if ($column['type'] == PUMPFORM_FILE) {
		    	if (@$_POST[$column['name'] . '_delete']) {
			    	$s = ' ' . $db->column_escape($column['name']) . ' = ';
			    	$file_id = 0;
					$s .= intval($file_id);
		    	} else {
			    	if (@$_FILES[$column['name']]['name'] == '') {
			    		continue;
			    	}
		    		if (@$_FILES[$column['name']]['name'] != '' &&
		    			@$_FILES[$column['name']]['error'] != UPLOAD_ERR_OK) {
		    			continue;
			    	}

			    	$s = ' `' . $column['name'] . '` = ';
			    	$file_id = $pumpfile->upload($column['name']);
					$s .= intval($file_id);
				}
		    } else if ($column['type'] == PUMPFORM_ADDRESS_AND_GMAP) {
		    	$s = ' ' . $db->column_escape($column['name']) . ' = ';
		    	$values[$p] = $_POST[$column['name']];
		    	$types[$p] = PC_Db::T_STRING;
		    	$s .= $p;
		    	array_push($columns, $s);
		    	$i++;
		    	$p = ':p' . $i;

		    	$v = preg_replace('/[^0-9\.]/', '', $_POST['geo_lat']);
		    	$v = $_POST['geo_lat'];
		    	$s = ' `geo_lat` = ' . $p . ', ';
		    	$values[$p] = $v;
		    	$types[$p] = PC_Db::T_DOUBLE;

		    	$i++;
		    	$p = ':p' . $i;

		    	$v = preg_replace('/[^0-9\.]/', '', $_POST['geo_lng']);
		    	$v = $_POST['geo_lng'];
		    	$s .= ' `geo_lng` = ' . $p;
		    	$values[$p] = $v;
		    	$types[$p] = PC_Db::T_DOUBLE;

		    } else if ($column['type'] == PUMPFORM_CHECKBOX) {
				$s = ' ' . $db->column_escape($column['name']) . ' = ';
				if (@$_POST[$column['name']]) {
				    $v = 1;
				} else {
				    $v = 0;
				}

				$values[$p] = $v;
				$types[$p] = PC_Db::T_INT;
				$s .= $p;
			} else if ($column['type'] == PUMPFORM_MULTI_CHECKBOX) {
				$t = $column['option']['link_table'];
				$module = $t['module'];
				$table = $t['table'];
				$ormap = PumpORMAP_Util::getInstance($module, $table);
				$list = @$_POST[$column['name']];
				$id1 = $column['option']['link_table']['id1'];
				$id2 = $column['option']['link_table']['id2'];
				$ormap->delete_where('`' . $id1 . '` = ' . intval($id));
				$list = @$_POST[$column['name']];
				foreach ($list as $value) {
					$ormap->insert(array($id1 => $id, $id2 => intval($value)));
				}
				continue;
	    	} else {
				//if (@$_POST[$column['name']] == '') {
			    	//continue;
				//}
		
				$s = ' ' . $db->column_escape($column['name']) . ' = ';
				$values[$p] = $_POST[$column['name']];
				$types[$p] = PC_Db::T_STRING;
				$s .= $p;
	    	}
		    array_push($columns, $s);
		}
		$sql .= implode(', ', $columns);
		if ($where == '') {
			$sql .= ' WHERE id = ' . intval($id);			
		} else {
			$sql .= ' WHERE ' . $where;
		}

		$db->exec($sql, $values, $types);

	    $this->_row_count = $db->row_count();
    }

    
    public function delete($id) {
		$db = PC_DBSet::get();

		$table = $this->get_table();

		$sql = 'DELETE FROM ' . $db->prefix($table);
		$sql .= ' WHERE ';
		$sql .= $db->column_escape('id');
		$sql .= ' = ' . intval($id);

		$db->query($sql);
    }
    
    public function delete_where($where) {
		$db = PC_DBSet::get();

		$table = $this->get_table();

		$sql = 'DELETE FROM ' . $db->prefix($table);
	    $sql .= ' WHERE site_id = ' . intval(PC_Config::get('site_id')) . ' AND ';
	    $sql .= $where;

		$db->query($sql);
    }

    public function row_count() {
    	return $this->_row_count;
    }
}

