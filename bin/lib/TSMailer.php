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
		#src/TSMailer.hx:34: characters 3-60
		$this->_result = new _HxAnon_TSMailer0("failed", "", "");
		#src/TSMailer.hx:35: characters 3-58
		require_once("vendor/autoload.php");
		#src/TSMailer.hx:36: characters 32-53
		$tmp = "Swift_SmtpTransport";
		#src/TSMailer.hx:36: characters 3-74
		$this->transport = new $tmp("smtp.salt.ch", 25);
		#src/TSMailer.hx:37: characters 15-24
		$tmp = $this->transport;
		#src/TSMailer.hx:37: characters 3-52
		$tmp->setUsername("bbaudry");
		#src/TSMailer.hx:40: characters 29-43
		$tmp = "Swift_Mailer";
		#src/TSMailer.hx:40: characters 3-55
		$this->mailer = new $tmp($this->transport);
		#src/TSMailer.hx:44: characters 3-23
		$this->route = Web::getURI();
		#src/TSMailer.hx:45: characters 3-27
		$this->params = Web::getParams();
		#src/TSMailer.hx:46: characters 3-20
		$this->shouldSend = true;
		#src/TSMailer.hx:50: lines 50-65
		if (array_key_exists("subject", $this->params->data)) {
			#src/TSMailer.hx:52: characters 25-51
			$tmp = ($this->params->data["subject"] ?? null);
			#src/TSMailer.hx:52: characters 4-51
			$this->_result->additional = $tmp;
			#src/TSMailer.hx:53: characters 4-30
			$this->message = $this->prepareSubject();
			#src/TSMailer.hx:54: characters 4-17
			$this->prepareBody();
			#src/TSMailer.hx:55: characters 4-15
			$this->prepareTo();
			#src/TSMailer.hx:57: characters 4-17
			$this->prepareFrom();
			#src/TSMailer.hx:58: characters 4-15
			$this->prepareCc();
			#src/TSMailer.hx:59: characters 4-16
			$this->prepareBcc();
		} else {
			#src/TSMailer.hx:63: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:64: characters 4-40
			$this->_result->additional = ($this->_result->additional??'null') . "No subject; ";
		}
		#src/TSMailer.hx:67: lines 67-91
		if ($this->shouldSend) {
			#src/TSMailer.hx:70: characters 29-35
			$tmp = $this->mailer;
			#src/TSMailer.hx:70: characters 4-54
			$result = $tmp->send($this->message);
			#src/TSMailer.hx:71: lines 71-82
			if ($result) {
				#src/TSMailer.hx:73: characters 5-37
				$this->_result->status = "success";
				#src/TSMailer.hx:74: characters 5-23
				$this->_result->error = "";
			} else {
				#src/TSMailer.hx:79: characters 5-36
				$this->_result->status = "failed";
				#src/TSMailer.hx:80: characters 5-38
				$this->_result->error = "transport issue";
			}
		} else {
			#src/TSMailer.hx:88: characters 4-35
			$this->_result->status = "failed";
			#src/TSMailer.hx:89: characters 4-42
			$this->_result->error = "missing key variable";
		}
		#src/TSMailer.hx:92: characters 3-40
		echo(\Std::string(Json::phpJsonEncode($this->_result, null, null)));
	}

	/**
	 * @return void
	 */
	public function prepareBcc () {
		#src/TSMailer.hx:110: characters 3-16
		$bcc = new HxAnon();
		#src/TSMailer.hx:111: lines 111-120
		if (array_key_exists("bcc_email", $this->params->data)) {
			#src/TSMailer.hx:113: characters 4-52
			$t = HxString::split(($this->params->data["bcc_email"] ?? null), ",");
			#src/TSMailer.hx:114: lines 114-117
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:114: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:114: lines 114-117
				++$_g;
				#src/TSMailer.hx:116: characters 5-34
				\Reflect::setField($bcc, $i, "");
			}
			#src/TSMailer.hx:119: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:119: characters 4-69
			$tmp->setBcc(((array)($bcc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareBody () {
		#src/TSMailer.hx:97: lines 97-105
		if (array_key_exists("body", $this->params->data)) {
			#src/TSMailer.hx:99: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:99: characters 4-73
			$tmp->setBody(($this->params->data["body"] ?? null), "text/html");
		} else {
			#src/TSMailer.hx:103: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:104: characters 4-38
			$this->_result->additional = ($this->_result->additional??'null') . " No BODY; ";
		}
	}

	/**
	 * @return void
	 */
	public function prepareCc () {
		#src/TSMailer.hx:125: characters 3-15
		$cc = new HxAnon();
		#src/TSMailer.hx:126: lines 126-136
		if (array_key_exists("cc_email", $this->params->data)) {
			#src/TSMailer.hx:128: characters 4-51
			$t = HxString::split(($this->params->data["cc_email"] ?? null), ",");
			#src/TSMailer.hx:131: lines 131-134
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:131: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:131: lines 131-134
				++$_g;
				#src/TSMailer.hx:133: characters 5-33
				\Reflect::setField($cc, $i, "");
			}
			#src/TSMailer.hx:135: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:135: characters 4-67
			$tmp->setCc(((array)($cc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareFrom () {
		#src/TSMailer.hx:156: characters 3-17
		$from = new HxAnon();
		#src/TSMailer.hx:158: lines 158-162
		if (!array_key_exists("from_email", $this->params->data)) {
			#src/TSMailer.hx:160: characters 4-48
			$this->params->data["from_email"] = "qook@salt.ch";
			#src/TSMailer.hx:161: characters 4-57
			$this->params->data["from_full_name"] = "qook troubleshoooting";
		}
		#src/TSMailer.hx:163: characters 3-135
		\Reflect::setField($from, ($this->params->data["from_email"] ?? null), (array_key_exists("from_full_name", $this->params->data) ? ($this->params->data["from_full_name"] ?? null) : ""));
		#src/TSMailer.hx:164: characters 15-22
		$tmp = $this->message;
		#src/TSMailer.hx:164: characters 3-70
		$tmp->setFrom(((array)($from)));
	}

	/**
	 * @return mixed
	 */
	public function prepareSubject () {
		#src/TSMailer.hx:169: characters 27-42
		$tmp = "Swift_Message";
		#src/TSMailer.hx:169: characters 3-71
		return new $tmp(($this->params->data["subject"] ?? null));
	}

	/**
	 * @return void
	 */
	public function prepareTo () {
		#src/TSMailer.hx:141: characters 3-15
		$to = new HxAnon();
		#src/TSMailer.hx:142: lines 142-151
		if (array_key_exists("to_email", $this->params->data)) {
			#src/TSMailer.hx:144: characters 4-127
			\Reflect::setField($to, ($this->params->data["to_email"] ?? null), (array_key_exists("to_full_name", $this->params->data) ? ($this->params->data["to_full_name"] ?? null) : ""));
			#src/TSMailer.hx:145: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:145: characters 4-67
			$tmp->setTo(((array)($to)));
		} else {
			#src/TSMailer.hx:149: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:150: characters 4-36
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
