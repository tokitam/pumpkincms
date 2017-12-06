<?php

require_once PUMPCMS_APP_PATH . '/module/user/plugin/monthly_paypal/form_config.php';
require_once PUMPCMS_APP_PATH . '/module/user/plugin/monthly_paypal/monthly_paypal_model.php';

class monthly_paypal {
    const PAYMENT_TYPE = 101;
    
    //var $api_url = 'https://api-3t.paypal.com/nvp';
    var $api_url = 'https://api-3t.sandbox.paypal.com/nvp';
    //var $auth_url = 'https://www.paypal.com/jp/cgi-bin/webscr?cmd=_express-checkout&token=';
    var $auth_url = 'https://www.sandbox.paypal.com/jp/cgi-bin/webscr?cmd=_express-checkout&token=';
    var $VERSION = '124';
    var $USER;
    var $PWD;
    var $SIGNATURE;
    var $DESC;
      
    public function __construct() {
        $flg = PC_Config::get('payment_monthly_paypal');
        if (empty($flg)) {
            
        }
        
        $this->USER = PC_Config::get('payment_monthly_paypal_user');
        $this->PWD = PC_Config::get('payment_monthly_paypal_password');
        $this->SIGNATURE = PC_Config::get('payment_monthly_paypal_signature');
        $this->DESC = PC_Config::get('payment_monthly_paypal_desc');
    }
    
    public function set() {
        if (UserInfo::is_loggedin() == false) {        
            echo _MD_USER_PLEASE_LOGIN;
            return;
        }
        
        if (UserInfo::is_premium()) {
            echo _MD_USER_ALREADY_PREMIUM;
            return;
        }

        $param = [];
        $param['METHOD'] = 'SetExpressCheckout';
        $param['VERSION'] = $this->VERSION;
        $param['USER'] = $this->USER;
        $param['PWD'] = $this->PWD;
        $param['SIGNATURE'] = $this->SIGNATURE;
        $param['PAYMENTREQUEST_0_AMT'] = '540';
        $param['PAYMENTREQUEST_0_CURRENCYCODE'] = 'JPY';
        $param['RETURNURL'] = PC_Config::url() . '/user/payment/?type=monthly_paypal&action=finish';
        $param['CANCELURL'] = PC_Config::url() . '/user/payment/?cancel_url';
        $param['LOCALECODE'] = 'jp_JP';
        $param['L_BILLINGTYPE0'] = 'RecurringPayments';
        $param['BILLINGAGREEMENTDESCRIPTION'] = $this->DESC;
        $param['L_BILLINGAGREEMENTDESCRIPTION0'] = $this->DESC;
        //$param['PAYMENTREQUEST_0_PAYMENTACTION'] = 'Sale';
        

        $res = PC_Util::curl($this->api_url, $param, 'POST');
        parse_str($res, $p);
        
        $monthly_payapl_model = new monthly_payapl_model();
        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['method'] = $param['METHOD'];
        $data['token'] = $p['TOKEN'];
        $data['timestamp'] = $p['TIMESTAMP'];
        $data['correlationid'] = $p['CORRELATIONID'];
        $data['ack'] = $p['ACK'];
        $data['version'] = $p['VERSION'];
        $data['build'] = $p['BUILD'];
        $monthly_payapl_model->add_log($data);

        //var_dump($p);
        //return;
        
        if (empty($p['ACK']) || $p['ACK'] != 'Success' || empty($p['TOKEN'])) {
            // error
            echo 'API failure';
            PC_Debug::log('API Failure: monthly_paypal::finish()', __FILE__, __LINE__);
            return;
        }

        $_SESSION['token'] = $p['TOKEN'];
        $url = $this->auth_url;
        $url .= $p['TOKEN'];
        
        header('Location:' . $url);
        exit();
    }
    
    public function setx() {
        echo ' set ' . __FILE__ . ':' . __LINE__;
        $METHOD = 'SetExpressCheckout';
        $PAYMENTREQUEST_0_AMT = '540';
        $PAYMENTREQUEST_0_CURRENCYCODE = 'JPY';
        $RETURNURL = urlencode(PC_Config::url() . '/user/payment/?type=monthly_paypal&action=finish');
        $CANCELURL = urlencode(PC_Config::url() . '/user/payment/?cancel_url');
        $BILLINGAGREEMENTDESCRIPTION = urlencode($this->DESC);
        $L_BILLINGAGREEMENTDESCRIPTION0 = urlencode($this->DESC);
        $PAYMENTREQUEST_0_PAYMENTACTION = 'Sale';
        $PAYMENTREQUEST_0_NOTIFYURL = urlencode(PC_Config::url() . '/user/payment/?notifyurl');

        $param = 'METHOD=' . $METHOD . 
                '&VERSION=' . $this->VERSION . 
                '&USER=' . $this->USER . 
                '&PWD=' . $this->PWD .
                '&SIGNATURE=' . $this->SIGNATURE .
                '&PAYMENTREQUEST_0_AMT=' . $PAYMENTREQUEST_0_AMT .
                '&RETURNURL=' . $RETURNURL .
                '&CANCELURL=' . $CANCELURL .
                '&LOCALECODE=jp_JP' .
                '&L_BILLINGTYPE0=RecurringPayments' .
                '&L_BILLINGAGREEMENTDESCRIPTION0=' . $L_BILLINGAGREEMENTDESCRIPTION0 .
                '&PAYMENTREQUEST_0_NOTIFYURL=' . $PAYMENTREQUEST_0_NOTIFYURL .
                '&NOTIFYURL=' . $PAYMENTREQUEST_0_NOTIFYURL .
                '&NOTIFY_URL=' . $PAYMENTREQUEST_0_NOTIFYURL;

        $url = $this->api_url . '?' . $param;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $res = curl_exec($curl);
        curl_close($curl);
        parse_str($res, $p);
        
        //var_dump($p);
        //return;

        $_SESSION['token'] = $p['TOKEN'];
        $url = $this->auth_url;
        $url .= $p['TOKEN'];
        
        header('Location:' . $url);
        exit();
    }
    
    public function finish() {
        if (UserInfo::is_loggedin() == false) {        
            echo _MD_USER_PLEASE_LOGIN;
            return;
        }
        
        if (UserInfo::is_premium()) {
            echo _MD_USER_ALREADY_PREMIUM;
            return;
        }

        $monthly_payapl_model = new monthly_payapl_model();
        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['method'] = 'SetExpressCheckout_callback';
        $data['token'] = @$_GET['token'];
        $data['payerid'] = @$_GET['PayerID'];
        $monthly_payapl_model->add_log($data);

        if (empty($_GET['PayerID']) || empty($_GET['token'])) {
            // error
            echo 'API failure(1)';
            PC_Debug::log('API Faire: monthly_paypal::finish()', __FILE__, __LINE__);
            return;
        }
        
        $param = [];
        $param['METHOD'] = 'CreateRecurringPaymentsProfile';
        $param['USER'] = $this->USER;
        $param['PWD'] = $this->PWD;
        $param['SIGNATURE'] = $this->SIGNATURE;
        $param['VERSION'] = $this->VERSION;
        $param['TOKEN'] = $_GET['token'];
        //$param['TOKEN'] = $_SESSION['token'];
        $param['PAYERID'] = $_GET['PayerID'];
        $param['PROFILESTARTDATE'] = gmdate("Y-m-d\TH:i:s\Z");
        $param['PROFILEREFERENCE'] = 795;
        $param['MAXFAILEDPAYMENTS'] = 1;

        $param['SUBSCRIBERNAME'] = 'TESTSUBSCRIBERNAME';
          
        $param['SHIPTONAME'] = 'TESTSHOP';
        $param['SHIPTOSTREET'] = 'OHKUBO';
        $param['SHIPTOCITY'] = 'SHINJUKU';
        $param['SHIPTOSTATE'] = 'TOKITA';
        $param['SHIPTOZIP'] = '1691234';
        $param['SHIPTOCOUNTRY'] = 'JP';
        
        //$_SESSION['TOKEN'] = $TOKEN;
        //$_SESSION['PAYERID'] = $PAYERID;
          
        $param['AMT'] = 540;
          
        $param['BILLINGPERIOD'] = 'Month';
        $param['BILLINGFREQUENCY'] = 1;
        $param['DESC'] = $this->DESC;

        $param['UPAYMENTREQUEST_0_AMT'] = 0;
        $param['PAYMENTREQUEST_0_AMT'] = 540;
        $param['PAYMENTREQUEST_0_CURRENCYCODE'] = 'JPY';
          
        $param['CURRENCYCODE'] = 'JPY';
        $param['COUNTRYCODE'] = 'JP';
        $param['MAXFAILEDPAYMENTS'] = 3;
        //$param['AUTOBILLAMT'] = 'AddToNextBilling';

        $res = PC_Util::curl($this->api_url, $param, 'POST');
        parse_str($res, $p);
        
        echo '<pre>';
var_dump($param);
var_dump($p);        
        echo '</pre>';

        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['method'] = $param['METHOD'];
        $data['token'] = @$_GET['token'];
        $data['payerid'] = @$_GET['PayerID'];
        $data['profileid'] = @$p['PROFILEID'];
        $data['profilestatus'] = @$p['PROFILESTATUS'];
        $data['timestamp'] = $p['TIMESTAMP'];
        $data['correlationid'] = $p['CORRELATIONID'];
        $data['ack'] = $p['ACK'];
        $data['version'] = $p['VERSION'];
        $data['build'] = $p['BUILD'];
        $monthly_payapl_model->add_log($data);
        
        if (empty($p['ACK']) || $p['ACK'] != 'Success') {
            // 実行失敗
            echo 'API failure(2)';
            PC_Debug::log('API Failure: monthly_paypal::finish() ' . print_r($p, true), __FILE__, __LINE__);
            return;
        }

        // flg_premium をオンにする
        $user_model = new User_Model();
        $user_model->update_flg_premium(UserInfo::get_id(), true, self::PAYMENT_TYPE);
        UserInfo::reload();
        
        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['payerid'] = @$_GET['PayerID'];
        $data['profileid'] = @$p['PROFILEID'];
        $data['del_time'] = 0;
        $monthly_payapl_model->add_user($data);
        
        var_dump($p);
        $_SESSION['PROFILEID'] = $p['PROFILEID'];
        return;

        $_SESSION['token'] = $p['TOKEN'];
        $url = $this->auth_url;
        $url .= $p['TOKEN'];
        
        //header('Location:' . $url);
    //    exit();
    }
    
    public function finishx() {
        echo ' finish ' . __FILE__ . ':' . __LINE__;
        $METHOD = 'CreateRecurringPaymentsProfile';
        $TOKEN = $_GET['token'];
        //$TOKEN = $_SESSION['token'];
        $PAYERID = $_GET['PayerID'];
        $PROFILESTARTDATE =gmdate("Y-m-d\TH:i:s\Z");
        var_dump($PROFILESTARTDATE);
        
        $SUBSCRIBERNAME = 'TESTSUBSCRIBERNAME';
          
        $SHIPTONAME = 'TESTSHOP';
        $SHIPTOSTREET = 'OHKUBO';
        $SHIPTOCITY = 'SHINJUKU';
        $SHIPTOSTATE = 'TOKITA';
        $SHIPTOZIP = '1691234';
        $SHIPTOCOUNTRY = 'JAPAN';
        
        $_SESSION['TOKEN'] = $TOKEN;
        $_SESSION['PAYERID'] = $PAYERID;
          
        $AMT = 540;
          
        $BILLINGPERIOD = 'Month';
        $BILLINGFREQUENCY = 1;
        $DESC = urlencode($this->DESC);

        $UPAYMENTREQUEST_0_AMT = 0;
        $PAYMENTREQUEST_0_AMT = 540;
        $PAYMENTREQUEST_0_CURRENCYCODE = 'JPY';
          
        $CURRENCYCODE = 'JPY';
        $COUNTRYCODE = 'JP';
        $MAXFAILEDPAYMENTS = 3;
        
        $param = 
          'USER=' . urlencode($this->USER) .
          '&PWD=' . $this->PWD .
          '&SIGNATURE=' . $this->SIGNATURE .
          '&VERSION=' . $this->VERSION .
          '&METHOD=' . $METHOD . 
          '&TOKEN=' . urlencode($TOKEN) .
          '&PAYERID=' . $PAYERID . 
          '&SUBSCRIBERNAME=' . $SUBSCRIBERNAME . 
          '&PROFILESTARTDATE=' . $PROFILESTARTDATE .
          '&PROFILEREFERENCE=795' .
          '&DESC=' . $DESC .
          '&MAXFAILEDPAYMENTS=1' .
          '&AUTOBILLAMT=AddToNextBilling' .
          '&BILLINGPERIOD=' . $BILLINGPERIOD .
          '&BILLINGFREQUENCY=' . $BILLINGFREQUENCY .
          '&AMT=' . $AMT . 
//          '&INITAMT=' . $AMT . 
          '&CURRENCYCODE=' . $CURRENCYCODE .
          '&COUNTRYCODE=' . $COUNTRYCODE . 
          '&MAXFAILEDPAYMENTS=' . $MAXFAILEDPAYMENTS .
          '&UPAYMENTREQUEST_0_AMT=&' . $UPAYMENTREQUEST_0_AMT;
        
        $url = $this->api_url . '?' . $param;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $res = curl_exec($curl);
        curl_close($curl);
        parse_str($res, $p);
        
        if (empty($p['ACK']) || $p['ACK'] != 'Success') {
            // 実行失敗
        }
    
        var_dump($p);
        $_SESSION['PROFILEID'] = $p['PROFILEID'];
        return;

        $_SESSION['token'] = $p['TOKEN'];
        $url = $this->auth_url;
        $url .= $p['TOKEN'];
        
        //header('Location:' . $url);
    //    exit();
    }

    public function unsubscribe() {
        echo ' unsubscribe ' . __FILE__ . ':' . __LINE__;
        
        $monthly_payapl_model = new monthly_payapl_model();
        $profileid = $monthly_payapl_model->get_profileid(UserInfo::get_id());
        $profileid = $_SESSION['PROFILEID'];
        
        $param = [];
        $param['METHOD'] = 'ManageRecurringPaymentsProfileStatus';
        $param['VERSION'] = $this->VERSION;
        $param['USER'] = $this->USER;
        $param['PWD'] = $this->PWD;
        $param['SIGNATURE'] = $this->SIGNATURE;
        $param['PROFILEID'] = $profileid;
        $param['ACTION'] = 'Cancel';
        $param['NOTE'] = 'cancel description';
        
        var_dump($param);
        
        $option = [];
        $option['CURLOPT_SSL_VERIFYPEER'] = false;
        $option['CURLOPT_SSL_VERIFYHOST'] = false;
        
        $res = PC_Util::curl($this->api_url, $param, 'POST', $option);
        parse_str($res, $p);
        
        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['method'] = $param['METHOD'];
        $data['profileid'] = @$p['PROFILEID'];
        $data['timestamp'] = @$p['TIMESTAMP'];
        $data['correlationid'] = @$p['CORRELATIONID'];
        $data['ack'] = @$p['ACK'];
        $data['version'] = @$p['VERSION'];
        $data['build'] = @$p['BUILD'];
        $monthly_payapl_model->add_log($data);

        if (empty($p['ACK']) || $p['ACK'] != 'Success') {
            echo 'API failure(3)';
            PC_Debug::log('API Failure: monthly_paypal::unsubscription() ' . print_r($p, true), __FILE__, __LINE__);
            return;
        }
        
        // flg_premium をオフにする
        $user_model = new User_Model();
        $user_model->update_flg_premium(UserInfo::get_id(), false, 0);
        UserInfo::reload();
        
        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['profileid'] = $profileid;
        $data['del_time'] = time();
        $monthly_payapl_model->update_user_del($data);
        
        var_dump($p);
    }

    public function unsubscribex() {
        echo ' unsubscribe ' . __FILE__ . ':' . __LINE__;
        $METHOD = 'ManageRecurringPaymentsProfileStatus';
        $PROFILEID = $_SESSION['PROFILEID'];
        $ACTION = 'Cancel';
        $NOTE = urlencode('cancel description');
        
        $param = 'METHOD=' . $METHOD .
          '&VERSION=' . $this->VERSION .
          '&USER=' . $this->USER .
          '&PWD=' . $this->PWD .
          '&SIGNATURE=' . $this->SIGNATURE .
          '&PROFILEID=' . $PROFILEID .
          '&ACTION=' . $ACTION .
          '&NOTE=' . $NOTE;

        $url = $this->api_url;
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $res = curl_exec($curl);
        parse_str($res, $p);
        
        $monthly_payapl_model = new monthly_payapl_model();
        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['method'] = $param['METHOD'];
        $data['token'] = $p['TOKEN'];
        $data['timestamp'] = $p['TIMESTAMP'];
        $data['correlationid'] = $p['CORRELATIONID'];
        $data['ack'] = $p['ACK'];
        $data['version'] = $p['VERSION'];
        $data['build'] = $p['BUILD'];
        $monthly_payapl_model->add_log($data);
        
        $data = [];
        $data['user_id'] = UserInfo::get_id();
        $data['del_time'] = time();
        $monthly_payapl_model->update_user_del($data);
        
        var_dump($p);
    }

    public function detail() {
        echo ' detail ' . __FILE__ . ':' . __LINE__;
        $METHOD = 'GetRecurringPaymentsProfileDetails';
        $PROFILEID = $_SESSION['PROFILEID'];
        
        $param = 'METHOD=' . $METHOD .
          '&VERSION=' . $this->VERSION .
          '&USER=' . $this->USER .
          '&PWD=' . $this->PWD .
          '&SIGNATURE=' . $this->SIGNATURE .
          '&PROFILEID=' . $PROFILEID;

        $url = $this->api_url;
        
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
        $res = curl_exec($curl);
        parse_str($res, $p);
        var_dump($p);
    }
    
    public function notify() {
        PC_Debug::log('post:' . print_r($_POST, true), __FILE__, __LINE__);
    }
}
