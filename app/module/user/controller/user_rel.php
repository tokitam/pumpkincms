<?php

require_once PUMPCMS_APP_PATH . '/module/user/model/user_model.php';

class user_user_rel extends PC_Controller {
    public function __construct() {
		$this->_flg_scaffold = true;
		$this->_module = 'user';
		$this->_table = 'user_rel';
    }

    public function index() {
    	if (UserInfo::is_logined() == false) {
    		PC_Util::redirect_top();
    	}

        $this->render('add_account');
        return;

    	$method = 'add';

    	$this->scaffold($this->_module, $this->_table, $method);
    }

    public function add() {
        if (UserInfo::is_logined() == false) {
            exit();
        }

        if ($_POST['email'] == UserInfo::get('email')) {
            echo json_encode(['error' => 1, 'message' => _MD_USER_NO_SAME_ACCOUNT]);
            exit();
        }

        $user_model = new User_Model();
        PC_Util::include_language_file('user');

        $error = $user_model->login_validate();

        if (empty($error)) {
            $target_user = $user_model->_user_data;
            $user_id1 = UserInfo::get('id');
            $user_id2 = $target_user['id'];

            if ($user_id2 < $user_id1) {
                $tmp = $user_id2;
                $user_id2 = $user_id1;
                $user_id1 = $tmp;
            }

            $user_rel_ormap = PumpORMAP_Util::get('user', 'user_rel');
            $list = $user_rel_ormap->get_list('user_id1 = ' . intval($user_id1) . ' AND user_id2 = ' . intval($user_id2));

            if (! empty($list)) {
                echo json_encode(['error' => 1, 'message' => _MD_USER_FOUND_REL_ACCOUNT]);
                exit();         
            }

            $user_rel_ormap->insert(['user_id1' => $user_id1, 'user_id2' => $user_id2]);
            $user_model->add_user_rel($target_user['id']);

            $user_model->load_rel_user(UserInfo::get_id());
            PC_Notification::set(_MD_USER_ADDED_ACCOUNT);

            echo json_encode(['error' => 0, 'message' => _MD_USER_ADDED_ACCOUNT]);
            exit();
        }

        $buf = '';
        foreach ($error as $item) {
            $buf .= $item;
        }

        echo json_encode(['error' => 1, 'message' => $buf]);
        exit();
    }

    public function delete() {
        if (UserInfo::is_logined() == false) {
            exit();
        }

        if (empty($_POST['id'])) {
            echo json_encode(['error' => 0, 'message' => 'error']);
            exit();
        }

        $delete_user_id = intval($_POST['id']);

        $user_model = new User_Model();
        $user_model->delete_user_rel(UserInfo::get_id(), $delete_user_id);
        $user_model->load_rel_user(UserInfo::get_id());

        echo json_encode(['successful' => 1]);
        exit();
    }
}
