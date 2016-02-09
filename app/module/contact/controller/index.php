<?php

class contact_index extends PC_Controller {
    public function __construct()
    {

		$this->_flg_scaffold = true;
		$this->_module = 'contact';
		$this->_table = 'contact';
    }

	public function index()
    {
    	$this->add();
    }

    public function add()
    {
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
	    	parent::add();
	    } else {
            $this->contact_mail($_POST['email'], $_POST['name'], $_POST['body']);
	    	echo 'Thank you for contact!!';
	    }
    }

    private function contact_mail($to, $name, $body)
    {
        $subject = 'You got contact';
        $body = 'name:' . $name . "¥r¥n" . $body;
        PC_Util::mail($to, $subject, $body);
    }
}
