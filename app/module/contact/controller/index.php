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
            echo _MD_CONTACT_THANKYOU;
        }
    }

    private function contact_mail($mail, $name, $body)
    {
        $to = PC_Config::get('admin_email');
        if (empty($to)) {
            return;
        }

        $subject = 'You got contact';
        $body = 'mail:' . $mail . ' name:' . $name . ' body:' . $body;
        PC_Util::mail($to, $subject, $body);
    }
}
