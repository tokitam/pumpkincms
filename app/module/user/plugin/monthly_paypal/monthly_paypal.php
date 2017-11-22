<?php

class monthly_paypal {
	var $api_url = 'https://api-3t.paypal.com/nvp';
	//var $api_url = 'https://api-3t.sandbox.paypal.com/nvp';
	var $auth_url = 'https://www.paypal.com/jp/cgi-bin/webscr?cmd=_express-checkout&token=';
	//var $auth_url = 'https://www.sandbox.paypal.com/jp/cgi-bin/webscr?cmd=_express-checkout&token=';
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
		echo ' finish ' . __FILE__ . ':' . __LINE__;
		$METHOD = 'CreateRecurringPaymentsProfile';
		$TOKEN = $_GET['token'];
		//$TOKEN = $_SESSION['token'];
		$PAYERID = $_GET['PayerID'];
		$PROFILESTARTDATE = urlencode(date('Y-m-d', strtotime('now')) .'T0:0:0');
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
		  '&INITAMT=' . $AMT . 
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
	
		var_dump($p);
		$_SESSION['PROFILEID'] = $p['PROFILEID'];
		return;

		$_SESSION['token'] = $p['TOKEN'];
		$url = $this->auth_url;
		$url .= $p['TOKEN'];
		
		//header('Location:' . $url);
	//	exit();
	}
	
	public function unsubscribe() {
		echo ' unsubscribe ' . __FILE__ . ':' . __LINE__;
		$METHOD = 'ManageRecurringPaymentsProfileStatus';
		$PROFILEID = $_SESSION['PROFILEID'];
		$ACTION = 'Cancel';
		$NOTE = urlencode('キャンセル理由');
		
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
