<?php
/**
 * Haxe source file: src/TSMailer.hx
 */

use \php\_Boot\HxAnon;
use \php\Boot;
use \php\Web;
use \haxe\Json;
use \php\_Boot\HxString;
use \haxe\Exception as HaxeException;
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
		#src/TSMailer.hx:32: characters 3-72
		$this->_result = new _HxAnon_TSMailer0("failed", null, "", "");
		#src/TSMailer.hx:33: characters 3-58
		require_once("vendor/autoload.php");
		#src/TSMailer.hx:34: characters 32-53
		$tmp = "Swift_SmtpTransport";
		#src/TSMailer.hx:34: characters 3-74
		$this->transport = new $tmp("smtp.salt.ch", 25);
		#src/TSMailer.hx:35: characters 15-24
		$tmp = $this->transport;
		#src/TSMailer.hx:35: characters 3-52
		$tmp->setUsername("bbaudry");
		#src/TSMailer.hx:38: characters 29-43
		$tmp = "Swift_Mailer";
		#src/TSMailer.hx:38: characters 3-55
		$this->mailer = new $tmp($this->transport);
		#src/TSMailer.hx:40: characters 3-23
		$this->route = Web::getURI();
		#src/TSMailer.hx:41: characters 3-27
		$this->params = Web::getParams();
		#src/TSMailer.hx:42: characters 3-20
		$this->shouldSend = true;
		#src/TSMailer.hx:43: characters 30-45
		$tmp = "Swift_Message";
		#src/TSMailer.hx:43: characters 3-57
		$this->message = new $tmp("ERRORED");
		#src/TSMailer.hx:47: lines 47-74
		if (array_key_exists("subject", $this->params->data)) {
			#src/TSMailer.hx:49: lines 49-67
			try {
				#src/TSMailer.hx:51: characters 5-16
				$this->prepareTo();
				#src/TSMailer.hx:53: characters 5-18
				$this->prepareFrom();
				#src/TSMailer.hx:54: characters 5-16
				$this->prepareCc();
				#src/TSMailer.hx:55: characters 5-17
				$this->prepareBcc();
				#src/TSMailer.hx:56: characters 5-18
				$this->prepareBody();
				#src/TSMailer.hx:57: characters 26-47
				$tmp = ($this->params->data["subject"] ?? null);
				#src/TSMailer.hx:57: characters 5-47
				$this->_result->additional = $tmp;
				#src/TSMailer.hx:58: characters 21-42
				$tmp = ($this->params->data["subject"] ?? null);
				#src/TSMailer.hx:58: characters 5-42
				$this->_result->debug = $tmp;
				#src/TSMailer.hx:59: characters 5-52
				$this->message = $this->prepareSubject(($this->params->data["subject"] ?? null));
				#src/TSMailer.hx:60: characters 5-28
				$this->_result->debug = $this->message;
			} catch(\Throwable $_g) {
				#src/TSMailer.hx:64: characters 11-12
				$e = HaxeException::caught($_g);
				#src/TSMailer.hx:66: characters 5-30
				$this->_result->debug = $e->get_message();
			}
		} else {
			#src/TSMailer.hx:72: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:73: characters 4-40
			$this->_result->additional = ($this->_result->additional??'null') . "No subject; ";
		}
		#src/TSMailer.hx:76: lines 76-100
		if ($this->shouldSend) {
			#src/TSMailer.hx:79: characters 29-35
			$tmp = $this->mailer;
			#src/TSMailer.hx:79: characters 4-54
			$result = $tmp->send($this->message);
			#src/TSMailer.hx:80: lines 80-91
			if ($result) {
				#src/TSMailer.hx:82: characters 5-31
				$this->_result->status = "success";
			} else {
				#src/TSMailer.hx:88: characters 5-30
				$this->_result->status = "failed";
				#src/TSMailer.hx:89: characters 5-38
				$this->_result->error = "transport issue";
			}
		} else {
			#src/TSMailer.hx:97: characters 4-29
			$this->_result->status = "failed";
			#src/TSMailer.hx:98: characters 4-42
			$this->_result->error = "missing key variable";
		}
		#src/TSMailer.hx:101: characters 3-40
		echo(\Std::string(Json::phpJsonEncode($this->_result, null, null)));
	}

	/**
	 * @return void
	 */
	public function prepareBcc () {
		#src/TSMailer.hx:119: characters 3-16
		$bcc = new HxAnon();
		#src/TSMailer.hx:120: lines 120-129
		if (array_key_exists("bcc_email", $this->params->data)) {
			#src/TSMailer.hx:122: characters 4-47
			$t = HxString::split(($this->params->data["bcc_email"] ?? null), ",");
			#src/TSMailer.hx:123: lines 123-126
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:123: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:123: lines 123-126
				++$_g;
				#src/TSMailer.hx:125: characters 5-34
				\Reflect::setField($bcc, $i, "");
			}
			#src/TSMailer.hx:128: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:128: characters 4-69
			$tmp->setBcc(((array)($bcc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareBody () {
		#src/TSMailer.hx:106: lines 106-114
		if (array_key_exists("body", $this->params->data)) {
			#src/TSMailer.hx:108: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:108: characters 4-68
			$tmp->setBody(($this->params->data["body"] ?? null), "text/html");
		} else {
			#src/TSMailer.hx:112: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:113: characters 4-38
			$this->_result->additional = ($this->_result->additional??'null') . " No BODY; ";
		}
	}

	/**
	 * @return void
	 */
	public function prepareCc () {
		#src/TSMailer.hx:134: characters 3-15
		$cc = new HxAnon();
		#src/TSMailer.hx:135: lines 135-145
		if (array_key_exists("cc_email", $this->params->data)) {
			#src/TSMailer.hx:137: characters 4-46
			$t = HxString::split(($this->params->data["cc_email"] ?? null), ",");
			#src/TSMailer.hx:140: lines 140-143
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:140: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:140: lines 140-143
				++$_g;
				#src/TSMailer.hx:142: characters 5-33
				\Reflect::setField($cc, $i, "");
			}
			#src/TSMailer.hx:144: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:144: characters 4-67
			$tmp->setCc(((array)($cc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareFrom () {
		#src/TSMailer.hx:165: characters 3-17
		$from = new HxAnon();
		#src/TSMailer.hx:167: lines 167-171
		if (!array_key_exists("from_email", $this->params->data)) {
			#src/TSMailer.hx:169: characters 4-44
			$this->params->data["from_email"] = "qook@salt.ch";
			#src/TSMailer.hx:170: characters 4-57
			$this->params->data["from_full_name"] = "qook troubleshoooting";
		}
		#src/TSMailer.hx:172: characters 3-121
		\Reflect::setField($from, ($this->params->data["from_email"] ?? null), (array_key_exists("from_full_name", $this->params->data) ? ($this->params->data["from_full_name"] ?? null) : ""));
		#src/TSMailer.hx:173: characters 15-22
		$tmp = $this->message;
		#src/TSMailer.hx:173: characters 3-70
		$tmp->setFrom(((array)($from)));
	}

	/**
	 * @param string $s
	 * 
	 * @return mixed
	 */
	public function prepareSubject ($s) {
		#src/TSMailer.hx:179: characters 27-42
		$tmp = "Swift_Message";
		#src/TSMailer.hx:179: characters 3-46
		return new $tmp($s);
	}

	/**
	 * @return void
	 */
	public function prepareTo () {
		#src/TSMailer.hx:150: characters 3-15
		$to = new HxAnon();
		#src/TSMailer.hx:151: lines 151-160
		if (array_key_exists("to_email", $this->params->data)) {
			#src/TSMailer.hx:153: characters 4-112
			\Reflect::setField($to, ($this->params->data["to_email"] ?? null), (array_key_exists("to_full_name", $this->params->data) ? ($this->params->data["to_full_name"] ?? null) : ""));
			#src/TSMailer.hx:154: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:154: characters 4-67
			$tmp->setTo(((array)($to)));
		} else {
			#src/TSMailer.hx:158: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:159: characters 4-36
			$this->_result->additional = ($this->_result->additional??'null') . " No TO; ";
		}
	}
}

class _HxAnon_TSMailer0 extends HxAnon {
	function __construct($status, $error, $additional, $debug) {
		$this->status = $status;
		$this->error = $error;
		$this->additional = $additional;
		$this->debug = $debug;
	}
}

Boot::registerClass(TSMailer::class, 'TSMailer');
