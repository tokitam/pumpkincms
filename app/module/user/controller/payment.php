<?php

class user_payment extends PC_Controller {
	const DESC = 'A timestamped token, the value of which';
    public function __construct() {
		/*
        $this->_flg_scaffold = true;
        $this->_module = 'user';
        $this->_table = 'user';
		 */
    }

    public function index() {
        if (UserInfo::is_logined() == false) {
            //PC_Util::redirect_top();
        }
		
		printf(" <a href='%s'>set</a><br /> ", PC_Config::url() . '/user/payment/?type=monthly_paypal&action=set');
		printf(" <a href='%s'>unsubscribe</a><br /> ", PC_Config::url() . '/user/payment/?type=monthly_paypal&action=unsubscribe');
		printf(" <a href='%s'>detail</a><br /> ", PC_Config::url() . '/user/payment/?type=monthly_paypal&action=detail');
		
		if (isset($_GET['type']) && preg_match('/^[_0-9A-Za-z]+$/', $_GET['type'])) {
			$plugin = $_GET['type'];
			require_once PUMPCMS_APP_PATH . '/module/user/plugin/' . $plugin . '/' . $plugin . '.php';
			$plugin_obj = new $plugin();
			if (isset($_GET['action']) && preg_match('/^[_0-9A-Za-z]+$/', $_GET['action'])) {
				$action = $_GET['action'];
				$plugin_obj->$action();
			}
		}
	}
	
    public function set() {
		$url = 'https://api-3t.sandbox.paypal.com/nvp';
		
		$METHOD = 'SetExpressCheckout';
		$VERSION = '124';
		$USER = 'tokita-facilitator_api1.pumpup.jp';
		$PWD = 'FRRRY9NXDSKQFVDG';
		$SIGNATURE = 'AGRlivd-w1.x76rooYVtlFKN43YvAAMRMxac2qBdNOB9vnDF4YrjB-uF';
		  
		$PAYMENTREQUEST_0_AMT = '540';
		$PAYMENTREQUEST_0_CURRENCYCODE = 'JPY';
		  
		$RETURNURL = urlencode('http://web23.tokita.net/user/payment/ret?type=paypal');
		$CANCELURL = urlencode('http://web23.tokita.net/user/payment/?cancel_url');
		$BILLINGAGREEMENTDESCRIPTION = urlencode(self::DESC);
		$L_BILLINGAGREEMENTDESCRIPTION0 = urlencode(self::DESC);
		  
		$PAYMENTREQUEST_0_PAYMENTACTION = 'Sale';
		
		$param =        'METHOD=' . $METHOD .
						'&VERSION=' . $VERSION . 
						'&USER=' . $USER . 
						'&PWD=' . $PWD .
 						'&SIGNATURE=' . $SIGNATURE .
						'&PAYMENTREQUEST_0_AMT=' . $PAYMENTREQUEST_0_AMT .
						//'&PAYMENTREQUEST_0_CURRENCYCODE=' . $PAYMENTREQUEST_0_CURRENCYCODE .
						'&RETURNURL=' . $RETURNURL .
						'&CANCELURL=' . $CANCELURL .
		                '&LOCALECODE=jp_JP' .
		                '&L_BILLINGTYPE0=RecurringPayments' .
		                '&L_BILLINGAGREEMENTDESCRIPTION0=' . $L_BILLINGAGREEMENTDESCRIPTION0;

		$url = $url . '?' . $param;
echo " $url ";		
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
		$res = curl_exec($curl);
		var_dump($res);
		$output = curl_close($curl);
		echo ' <hr /> ';
		var_dump($output);
		parse_str($res, $p);
		var_dump($p);
		
		$_SESSION['token'] = $p['TOKEN'];
		
		$url = 'https://www.sandbox.paypal.com/jp/cgi-bin/webscr?cmd=_express-checkout&token=';
		$url .= $p['TOKEN'];
		
		header('Location:' . $url);
		exit();
	}
	
	function ret() {
		var_dump($_GET);
		var_dump($_POST);
		
		
		$METHOD = 'CreateRecurringPaymentsProfile';
		$VERSION = '124';
		$VERSION = '86';
		$USER = 'tokita-facilitator_api1.pumpup.jp';
		$PWD = 'FRRRY9NXDSKQFVDG';
		$SIGNATURE = 'AGRlivd-w1.x76rooYVtlFKN43YvAAMRMxac2qBdNOB9vnDF4YrjB-uF';
		  
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
		$DESC = urlencode(self::DESC);

		$UPAYMENTREQUEST_0_AMT = 0;
		$PAYMENTREQUEST_0_AMT = 540;
		$PAYMENTREQUEST_0_CURRENCYCODE = 'JPY';
		  
		$CURRENCYCODE = 'JPY';
		$COUNTRYCODE = 'JP';
		$MAXFAILEDPAYMENTS = 3;
		
		$param = 
		  'USER=' . urlencode($USER) .
		  '&PWD=' . $PWD .
		  '&SIGNATURE=' . $SIGNATURE .
		  '&VERSION=' . $VERSION .
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
		  '&CURRENCYCODE=' . $CURRENCYCODE .
		  '&COUNTRYCODE=' . $COUNTRYCODE . 
		  '&MAXFAILEDPAYMENTS=' . $MAXFAILEDPAYMENTS .
		  '&UPAYMENTREQUEST_0_AMT=&' . $UPAYMENTREQUEST_0_AMT;
		
		$url = 'https://api-3t.sandbox.paypal.com/nvp';

		echo " param : $param <br />\n";
		echo " url : $url <br />\n";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_POSTFIELDS, $param);
		$res = curl_exec($curl);
		parse_str($res, $p);
		var_dump($p);
		
		echo "<br />\n";
		echo "<br />\n";

		$cancel_url = sprintf('%s/user/payment/cancel?token=%s&payerid=%s&profileid=%s', PC_Config::url(), $_SESSION['TOKEN'], $_SESSION['PAYERID'], $p['PROFILEID']);
		echo ' ' . $cancel_url . ' ';
		printf("<a href='%s'>cancel</a>\n", $cancel_url);
	}
	
	public function cancel() {
		
		$METHOD = 'GetRecurringPaymentsProfileDetails';
		$VERSION = 124;
		$USER = 'tokita-facilitator_api1.pumpup.jp';
		$PWD = 'FRRRY9NXDSKQFVDG';
		$SIGNATURE = 'AGRlivd-w1.x76rooYVtlFKN43YvAAMRMxac2qBdNOB9vnDF4YrjB-uF';
		$PROFILEID = $_GET['profileid'];
		
		$param = 'METHOD=' . $METHOD .
		  '&VERSION=' . $VERSION .
		  '&USER=' . $USER .
		  '&PWD=' . $PWD .
		  '&SIGNATURE=' . $SIGNATURE .
		  '&PROFILEID=' . $PROFILEID;
		
		echo ' ' . $param . ' ';
		
		$url = 'https://api-3t.sandbox.paypal.com/nvp';
		
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
}
