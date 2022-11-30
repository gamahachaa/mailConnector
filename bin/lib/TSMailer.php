<?php
/**
 * Haxe source file: src/TSMailer.hx
 */

use \php\_Boot\HxAnon;
use \php\Boot;
use \php\Web;
use \haxe\Json;
use \php\_Boot\HxString;
use \haxe\ds\StringMap;

class TSMailer {
	/**
	 * @var object
	 */
	public $_result;
	/**
	 * @var mixed
	 */
	public $body;
	/**
	 * @var mixed
	 */
	public $mailer;
	/**
	 * @var mixed
	 */
	public $message;
	/**
	 * @var StringMap
	 */
	public $params;
	/**
	 * @var string
	 */
	public $route;
	/**
	 * @var bool
	 */
	public $shouldSend;
	/**
	 * @var mixed
	 */
	public $transport;

	/**
	 * @return void
	 */
	public function __construct () {
		#src/TSMailer.hx:31: characters 3-62
		$this->_result = new _HxAnon_TSMailer0("failed", null, "");
		#src/TSMailer.hx:32: characters 3-58
		require_once("vendor/autoload.php");
		#src/TSMailer.hx:33: characters 32-53
		$tmp = "Swift_SmtpTransport";
		#src/TSMailer.hx:33: characters 3-74
		$this->transport = new $tmp("smtp.salt.ch", 25);
		#src/TSMailer.hx:34: characters 15-24
		$tmp = $this->transport;
		#src/TSMailer.hx:34: characters 3-52
		$tmp->setUsername("bbaudry");
		#src/TSMailer.hx:37: characters 29-43
		$tmp = "Swift_Mailer";
		#src/TSMailer.hx:37: characters 3-55
		$this->mailer = new $tmp($this->transport);
		#src/TSMailer.hx:39: characters 3-23
		$this->route = Web::getURI();
		#src/TSMailer.hx:40: characters 3-27
		$this->params = Web::getParams();
		#src/TSMailer.hx:41: characters 3-20
		$this->shouldSend = true;
		#src/TSMailer.hx:45: lines 45-60
		if (array_key_exists("subject", $this->params->data)) {
			#src/TSMailer.hx:47: characters 25-46
			$tmp = ($this->params->data["subject"] ?? null);
			#src/TSMailer.hx:47: characters 4-46
			$this->_result->additional = $tmp;
			#src/TSMailer.hx:48: characters 4-30
			$this->message = $this->prepareSubject();
			#src/TSMailer.hx:49: characters 4-17
			$this->prepareBody();
			#src/TSMailer.hx:50: characters 4-15
			$this->prepareTo();
			#src/TSMailer.hx:52: characters 4-17
			$this->prepareFrom();
			#src/TSMailer.hx:53: characters 4-15
			$this->prepareCc();
			#src/TSMailer.hx:54: characters 4-16
			$this->prepareBcc();
		} else {
			#src/TSMailer.hx:58: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:59: characters 4-40
			$this->_result->additional = ($this->_result->additional??'null') . "No subject; ";
		}
		#src/TSMailer.hx:62: lines 62-86
		if ($this->shouldSend) {
			#src/TSMailer.hx:65: characters 29-35
			$tmp = $this->mailer;
			#src/TSMailer.hx:65: characters 4-54
			$result = $tmp->send($this->message);
			#src/TSMailer.hx:66: lines 66-77
			if ($result) {
				#src/TSMailer.hx:68: characters 5-31
				$this->_result->status = "success";
			} else {
				#src/TSMailer.hx:74: characters 5-30
				$this->_result->status = "failed";
				#src/TSMailer.hx:75: characters 5-38
				$this->_result->error = "transport issue";
			}
		} else {
			#src/TSMailer.hx:83: characters 4-29
			$this->_result->status = "failed";
			#src/TSMailer.hx:84: characters 4-42
			$this->_result->error = "missing key variable";
		}
		#src/TSMailer.hx:87: characters 3-40
		echo(\Std::string(Json::phpJsonEncode($this->_result, null, null)));
	}

	/**
	 * @return void
	 */
	public function prepareBcc () {
		#src/TSMailer.hx:105: characters 3-16
		$bcc = new HxAnon();
		#src/TSMailer.hx:106: lines 106-115
		if (array_key_exists("bcc_email", $this->params->data)) {
			#src/TSMailer.hx:108: characters 4-47
			$t = HxString::split(($this->params->data["bcc_email"] ?? null), ",");
			#src/TSMailer.hx:109: lines 109-112
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:109: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:109: lines 109-112
				++$_g;
				#src/TSMailer.hx:111: characters 5-34
				\Reflect::setField($bcc, $i, "");
			}
			#src/TSMailer.hx:114: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:114: characters 4-69
			$tmp->setBcc(((array)($bcc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareBody () {
		#src/TSMailer.hx:92: lines 92-100
		if (array_key_exists("body", $this->params->data)) {
			#src/TSMailer.hx:94: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:94: characters 4-68
			$tmp->setBody(($this->params->data["body"] ?? null), "text/html");
		} else {
			#src/TSMailer.hx:98: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:99: characters 4-38
			$this->_result->additional = ($this->_result->additional??'null') . " No BODY; ";
		}
	}

	/**
	 * @return void
	 */
	public function prepareCc () {
		#src/TSMailer.hx:120: characters 3-15
		$cc = new HxAnon();
		#src/TSMailer.hx:121: lines 121-131
		if (array_key_exists("cc_email", $this->params->data)) {
			#src/TSMailer.hx:123: characters 4-46
			$t = HxString::split(($this->params->data["cc_email"] ?? null), ",");
			#src/TSMailer.hx:126: lines 126-129
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:126: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:126: lines 126-129
				++$_g;
				#src/TSMailer.hx:128: characters 5-33
				\Reflect::setField($cc, $i, "");
			}
			#src/TSMailer.hx:130: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:130: characters 4-67
			$tmp->setCc(((array)($cc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareFrom () {
		#src/TSMailer.hx:151: characters 3-17
		$from = new HxAnon();
		#src/TSMailer.hx:153: lines 153-157
		if (!array_key_exists("from_email", $this->params->data)) {
			#src/TSMailer.hx:155: characters 4-44
			$this->params->data["from_email"] = "qook@salt.ch";
			#src/TSMailer.hx:156: characters 4-57
			$this->params->data["from_full_name"] = "qook troubleshoooting";
		}
		#src/TSMailer.hx:158: characters 3-121
		\Reflect::setField($from, ($this->params->data["from_email"] ?? null), (array_key_exists("from_full_name", $this->params->data) ? ($this->params->data["from_full_name"] ?? null) : ""));
		#src/TSMailer.hx:159: characters 15-22
		$tmp = $this->message;
		#src/TSMailer.hx:159: characters 3-70
		$tmp->setFrom(((array)($from)));
	}

	/**
	 * @return mixed
	 */
	public function prepareSubject () {
		#src/TSMailer.hx:164: characters 27-42
		$tmp = "Swift_Message";
		#src/TSMailer.hx:164: characters 3-66
		return new $tmp(($this->params->data["subject"] ?? null));
	}

	/**
	 * @return void
	 */
	public function prepareTo () {
		#src/TSMailer.hx:136: characters 3-15
		$to = new HxAnon();
		#src/TSMailer.hx:137: lines 137-146
		if (array_key_exists("to_email", $this->params->data)) {
			#src/TSMailer.hx:139: characters 4-112
			\Reflect::setField($to, ($this->params->data["to_email"] ?? null), (array_key_exists("to_full_name", $this->params->data) ? ($this->params->data["to_full_name"] ?? null) : ""));
			#src/TSMailer.hx:140: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:140: characters 4-67
			$tmp->setTo(((array)($to)));
		} else {
			#src/TSMailer.hx:144: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:145: characters 4-36
			$this->_result->additional = ($this->_result->additional??'null') . " No TO; ";
		}
	}
}

class _HxAnon_TSMailer0 extends HxAnon {
	function __construct($status, $error, $additional) {
		$this->status = $status;
		$this->error = $error;
		$this->additional = $additional;
	}
}

Boot::registerClass(TSMailer::class, 'TSMailer');
