<?php

class PC_Model {
	var $table_name = null;
	
	function insert() {
		$form = new PumpForm();
		$form->insert('user', 'user');
		//PumpForm::insert('user', 'user');
		
	}

}

