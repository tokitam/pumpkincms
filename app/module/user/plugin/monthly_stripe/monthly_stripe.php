<?php

require_once(PUMPCMS_APP_PATH . '/module/user/plugin/monthly_stripe/monthly_stripe_model.php');
require_once(PUMPCMS_APP_PATH . '/module/user/model/user_model.php');

class monthly_stripe extends PC_Controller {
    const PAYMENT_TYPE = 201;
    public $add_post_process = null;
    public $subscription_post_url = null;
    public $unsubscription_post_url = null;
    public $premium_check_func = null;
    
    public function get_subscription_link() {
        return $this->get_form();
    }
    
    public function get_form() {
        if (empty($this->subscription_post_url)) {
            $url = PC_Config::url() . '/user/payment/?type=monthly_stripe&action=subscription';
        } else {
            $url = $this->subscription_post_url;
        }
        $pk = PC_Config::get('monthly_stripe_public_key');
        $amount = PC_Config::get('monthly_stripe_amount');
        $brand_name = htmlspecialchars(PC_Config::get('monthly_stripe_brand_name'));
        $description = htmlspecialchars(PC_Config::get('monthly_stripe_description'));
          
        $form = "
<form action='" . $url ."' method='POST'>
<script src='https://checkout.stripe.com/checkout.js' class='stripe-button'
data-key='" . $pk . "'
data-amount='" . $amount . "'
data-name='" . $brand_name . "'
data-description='" . $description . "'
data-image='https://stripe.com/img/documentation/checkout/marketplace.png'
data-locale='ja'
data-zip-code='true'
data-currency='jpy'
data-label='今すぐ申し込む'>
</script>
</form>
                  ";
        
        return $form;
    }

    public function get_cancel_link() {
        if (empty($this->subscription_post_url)) {
            $url = PC_Config::url() . '/user/payment?type=monthly_stripe&action=cancel';
        } else {
            $url = $this->subscription_post_url;
        }
        $form = "<a href='" . $url . "' class='btn btn-default' >" . _MD_USER_UNSUBSCRIBE . "</a>";
        
        return $form;
    }
    
    public function subscription($project_id=null) {
        PC_Debug::log('aaabbb OK', __FILE__, __LINE__);
        if (UserInfo::is_loggedin() == false) {
            echo _MD_USER_PLEASE_LOGIN;
        PC_Debug::log('aaabbb OK', __FILE__, __LINE__);
            return;
        }
        PC_Debug::log('aaabbb OK', __FILE__, __LINE__);
        
        if (empty($this->premium_check_func)) {
            if (UserInfo::is_premium()) {
                // すでにプレミアムユーザである
                echo _MD_USER_ALREADY_PREMIUM;
        PC_Debug::log('OK', __FILE__, __LINE__);
                return;
            }    
        } else {
            $func = $this->premium_check_func;
            $func();
        }
        PC_Debug::log('OK', __FILE__, __LINE__);
        
        // この辺で値のチェック
        if (empty($_POST['stripeEmail']) ||
            empty($_POST['stripeToken']) ||
            PC_Util::is_email($_POST['stripeEmail']) == false) {
            echo _MD_USER_VALUE_IS_INVALID;
            return;
        }
        PC_Debug::log('OK', __FILE__, __LINE__);
        
        $sk = PC_Config::get('monthly_stripe_secret_key');
        
        $url = 'https://api.stripe.com/v1/customers';
        $param = [
                  'email' => $_POST['stripeEmail'],
                  'source' => $_POST['stripeToken'],
                  ];
        $method = 'POST';
        $option = [
                   'user_password' => $sk,
                   'output_request_header' => false,
                   'output_response_header' => false,
                   ];
        $ret = PC_Util::curl($url, $param, $method, $option);
        $ret = json_decode($ret, true);
        PC_Debug::log('OK', __FILE__, __LINE__);
        
        // ここでエラー判定
        if (empty($ret['id'])) {
            // 応答が正しくない
            echo 'stripe api error';
            PC_Debug::log('stripe api customer error:' . print_r($ret, true), __FILE__, __LINE__);
            return;
        }
        PC_Debug::log('OK', __FILE__, __LINE__);
        
        if (isset($ret['error'])) {
            // エラーがある
            echo 'stripe api error';
            PC_Debug::log('stripe api customer error:' . print_r($ret, true), __FILE__, __LINE__);
            return;
        }
        
        $monthly_stripe_model = new monthly_stripe_model();
        $monthly_stripe_model->add_customer($ret);

        $plan = PC_Config::get('monthly_stripe_plan');
        if (empty($plan)) {
            $plan = 'basic-monthly';
        }
        
        $sk = PC_Config::get('monthly_stripe_secret_key') . ':';
        $url = 'https://api.stripe.com/v1/subscriptions';
        $param = [
                  'customer' => $ret['id'],
                  'items[0][plan]' => $plan,
                  ];
        $method = 'POST';
        $option = [
                   'user_password' => $sk,
                   'output_request_header' => false,
                   'output_response_header' => false,
                   ];
        PC_Debug::log('OK', __FILE__, __LINE__);

        $ret = PC_Util::curl($url, $param, $method, $option);
        $ret = json_decode($ret, true);

        // ここでエラー判定
        if (empty($ret['id'])) {
            // 応答が正しくない
            echo 'stripe api error';
            PC_Debug::log('stripe api customer error:' . print_r($ret, true), __FILE__, __LINE__);
            return;
        }
                PC_Debug::log('OK', __FILE__, __LINE__);

        if (isset($ret['error'])) {
            // エラーがある
            echo 'stripe api error';
            PC_Debug::log('stripe api customer error:' . print_r($ret, true), __FILE__, __LINE__);
            return;
        }
        
        $monthly_stripe_model = new monthly_stripe_model();
        $subscription_id = $monthly_stripe_model->add_subscription($ret, $project_id);
        PC_Config::set('subscription_id', $subscription_id);

        // flg_premium をオンにする
        $user_model = new User_Model();
        $user_model->update_flg_premium(UserInfo::get_id(), true, self::PAYMENT_TYPE);
        PC_Debug::log('OK', __FILE__, __LINE__);

        if (!empty($this->add_post_process)) {
            $func = $this->add_post_process;
            $func();
        }

        UserInfo::reload();
    }

    public function webhook() {
        $stdin = file_get_contents('php://input');

        PC_Debug::log('stdin:' . $stdin, __FILE__, __LINE__);
        PC_Debug::log('get:' . print_r($_GET, true), __FILE__, __LINE__);
        PC_Debug::log('post:' . print_r($_POST, true), __FILE__, __LINE__);

        $webhook = json_decode($stdin, true);
        PC_Debug::log('post:', __FILE__, __LINE__);
        
        if (empty($webhook['type'])) {
        PC_Debug::log('post:', __FILE__, __LINE__);
            exit();
        }
        PC_Debug::log('post:', __FILE__, __LINE__);

        $monthly_stripe_model = new monthly_stripe_model();
        PC_Debug::log('post:', __FILE__, __LINE__);
        $webhook = $monthly_stripe_model->arrangement_webhook($webhook);
        PC_Debug::log('post:', __FILE__, __LINE__);

        if (!empty($webhook['customer_id'])) {
        PC_Debug::log('post:', __FILE__, __LINE__);
            $customer = $monthly_stripe_model->get_customer($webhook['customer_id']);
            $webhook['user_id'] = intval($customer['user_id']);
        }
        $monthly_stripe_model->add_webhook($webhook);
        PC_Debug::log('post:', __FILE__, __LINE__);
        
        echo ' OK ';
        exit();
    }

    public function cancel($project_id=null) {

        if (UserInfo::is_loggedin() == false) {
            echo _MD_USER_PLEASE_LOGIN;
            return;
        }
        
        if (empty($this->premium_check_func)) {
            if (UserInfo::is_premium() == false) {
                // すでにプレミアムユーザではない
                echo _MD_USER_NOT_PREMIUM;
                return;
            }    
        } else {
            $func = $this->premium_check_func;
            $func();
        }
        PC_Debug::log(' project_id : ' . $project_id, __FILE__, __LINE__);
        $monthly_stripe_model = new monthly_stripe_model();
        $subscription = $monthly_stripe_model->get_last_subscription(UserInfo::get_id(), $project_id);
        
        PC_Debug::log(' subscription : ' . print_r($subscription, true), __FILE__, __LINE__);
        $sk = PC_Config::get('monthly_stripe_secret_key') . ':';
        $url = 'https://api.stripe.com/v1/subscriptions/' . $subscription['subscription_id'];
        $param = [];
        $method = 'DELETE';
        $option = [
                   'user_password' => $sk,
                   'output_request_header' => false,
                   'output_response_header' => false,
                   'CURLOPT_CUSTOMREQUEST' => 'DELETE',
                   ];
        echo '<pre>';
        $ret = PC_Util::curl($url, $param, $method, $option);
        var_dump($ret);
        $ret = json_decode($ret, true);
        
        // subscriptionテーブルの canceled_at を更新する
        $monthly_stripe_model = new monthly_stripe_model();
        $monthly_stripe_model->update_subscription_canceled_at($subscription['id']);
        PC_Config::set('subscription_id', $subscription['id']);

        // flg_premium をオフにする
        $user_model = new User_Model();
        $user_model->update_flg_premium(UserInfo::get_id(), false, 0);

        if (!empty($this->add_post_process)) {
            $func = $this->add_post_process;
            $func();
        }

        UserInfo::reload();
    }
    
    public function plan_list() {
        PC_Util::redirect_if_not_site_admin();
        $this->set_scaffold('user', 'payment_monthly_stripe_plan');
        $this->index();
    }
    
    public function plan_add() {
        PC_Util::redirect_if_not_site_admin();
        PumpForm::$redirect_url = PC_Config::url() . '/user/payment/?type=monthly_stripe&action=plan_list';
        $this->set_scaffold('user', 'payment_monthly_stripe_plan');
        $this->add();
    }
    
    public function plan_detail() {
        PC_Util::redirect_if_not_site_admin();
        PumpForm::$edit_url = PC_Config::url() . '/user/payment/?type=monthly_stripe&action=plan_edit&id=' . intval($_GET['id']);
        $this->set_scaffold('user', 'payment_monthly_stripe_plan');
        $this->detail();
    }
    
    public function plan_edit() {
        PC_Util::redirect_if_not_site_admin();
        PumpForm::$target_id = intval($_GET['id']);
        PumpForm::$redirect_url = PC_Config::url() . '/user/payment/?type=monthly_stripe&action=plan_list';
        $this->set_scaffold('user', 'payment_monthly_stripe_plan');
        $this->edit();
    }
    
    public function plan_delete() {
        PC_Util::redirect_if_not_site_admin();
        PumpForm::$target_id = intval($_GET['id']);
        $this->set_scaffold('user', 'payment_monthly_stripe_plan');
        $this->delete();
    }
}
