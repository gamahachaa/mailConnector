<?php
/**
 */

use \haxe\io\_BytesData\Container;
use \php\_Boot\HxAnon;
use \php\Boot;
use \php\Web;
use \haxe\Json;
use \php\_Boot\HxString;
use \haxe\crypto\Base64;
use \haxe\ds\StringMap;
use \haxe\io\Bytes;

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
	 * @var object
	 */
	public $img;
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
		#src/TSMailer.hx:39: characters 3-60
		$this->_result = new _HxAnon_TSMailer0("failed", "", "");
		#src/TSMailer.hx:40: characters 3-58
		require_once("vendor/autoload.php");
		#src/TSMailer.hx:41: characters 32-53
		$tmp = "Swift_SmtpTransport";
		#src/TSMailer.hx:41: characters 3-74
		$this->transport = new $tmp("smtp.salt.ch", 25);
		#src/TSMailer.hx:42: characters 15-24
		$tmp = $this->transport;
		#src/TSMailer.hx:42: characters 3-52
		$tmp->setUsername("bbaudry");
		#src/TSMailer.hx:45: characters 29-43
		$tmp = "Swift_Mailer";
		#src/TSMailer.hx:45: characters 3-55
		$this->mailer = new $tmp($this->transport);
		#src/TSMailer.hx:47: characters 3-23
		$this->route = Web::getURI();
		#src/TSMailer.hx:48: characters 3-27
		$this->params = Web::getParams();
		#src/TSMailer.hx:49: characters 3-20
		$this->shouldSend = true;
		#src/TSMailer.hx:53: lines 53-68
		if (array_key_exists("subject", $this->params->data)) {
			#src/TSMailer.hx:55: characters 25-51
			$tmp = ($this->params->data["subject"] ?? null);
			#src/TSMailer.hx:55: characters 4-51
			$this->_result->additional = $tmp;
			#src/TSMailer.hx:56: characters 4-30
			$this->message = $this->prepareSubject();
			#src/TSMailer.hx:57: characters 4-17
			$this->prepareBody();
			#src/TSMailer.hx:58: characters 4-15
			$this->prepareTo();
			#src/TSMailer.hx:60: characters 4-17
			$this->prepareFrom();
			#src/TSMailer.hx:61: characters 4-15
			$this->prepareCc();
			#src/TSMailer.hx:62: characters 4-16
			$this->prepareBcc();
		} else {
			#src/TSMailer.hx:66: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:67: characters 4-40
			$this->_result->additional = ($this->_result->additional??'null') . "No subject; ";
		}
		#src/TSMailer.hx:70: lines 70-94
		if ($this->shouldSend) {
			#src/TSMailer.hx:73: characters 29-35
			$tmp = $this->mailer;
			#src/TSMailer.hx:73: characters 4-54
			$result = $tmp->send($this->message);
			#src/TSMailer.hx:74: lines 74-85
			if ($result) {
				#src/TSMailer.hx:76: characters 5-37
				$this->_result->status = "success";
				#src/TSMailer.hx:77: characters 5-23
				$this->_result->error = "";
			} else {
				#src/TSMailer.hx:82: characters 5-36
				$this->_result->status = "failed";
				#src/TSMailer.hx:83: characters 5-38
				$this->_result->error = "transport issue";
			}
		} else {
			#src/TSMailer.hx:91: characters 4-35
			$this->_result->status = "failed";
			#src/TSMailer.hx:92: characters 4-42
			$this->_result->error = "missing key variable";
		}
		#src/TSMailer.hx:95: characters 3-40
		echo(\Std::string(Json::phpJsonEncode($this->_result, null, null)));
	}

	/**
	 * @return void
	 */
	public function prepareBcc () {
		#src/TSMailer.hx:172: characters 3-16
		$bcc = new HxAnon();
		#src/TSMailer.hx:173: lines 173-182
		if (array_key_exists("bcc_email", $this->params->data)) {
			#src/TSMailer.hx:175: characters 4-52
			$t = HxString::split(($this->params->data["bcc_email"] ?? null), ",");
			#src/TSMailer.hx:176: lines 176-179
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:176: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:176: lines 176-179
				++$_g;
				#src/TSMailer.hx:178: characters 5-34
				\Reflect::setField($bcc, $i, "");
			}
			#src/TSMailer.hx:181: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:181: characters 4-69
			$tmp->setBcc(((array)($bcc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareBody () {
		#src/TSMailer.hx:100: lines 100-167
		if (array_key_exists("body", $this->params->data)) {
			#src/TSMailer.hx:102: characters 4-36
			$b = ($this->params->data["body"] ?? null);
			#src/TSMailer.hx:104: lines 104-160
			if (array_key_exists("image", $this->params->data)) {
				#src/TSMailer.hx:106: lines 106-113
				$n = (array_key_exists("imagefullname", $this->params->data) ? HxString::split(urldecode(($this->params->data["imagefullname"] ?? null)), " ")->join("") : "");
				#src/TSMailer.hx:117: characters 28-72
				$str = ($this->params->data["image"] ?? null);
				$s = base64_decode(str_replace(Base64::$URL_62_63, Base64::$NORMAL_62_63, $str), true);
				$bytes = strlen($s);
				#src/TSMailer.hx:117: characters 14-73
				$result = base64_encode((new Bytes($bytes, new Container($s)))->toString());
				#src/TSMailer.hx:115: lines 115-119
				$img_bytes = $result;
				$img_name = $n;
				#src/TSMailer.hx:120: lines 120-136
				$mime = (HxString::indexOf(mb_strtolower($img_name), ".gif") > -1 ? "image/gif" : (HxString::indexOf(mb_strtolower($img_name), ".png") > -1 ? "image/png" : ((HxString::indexOf(mb_strtolower($img_name), ".jpg") > -1) || (HxString::indexOf(mb_strtolower($img_name), ".jpeg") > -1) ? "image/jpeg" : "application/unknown")));
				#src/TSMailer.hx:138: characters 5-48
				$src = "data:" . ($mime??'null') . ";base64," . ($img_bytes??'null');
				#src/TSMailer.hx:139: characters 5-57
				$imgHtml = "<img src=\"" . ($src??'null') . "\" alt=\"" . ($img_name??'null') . "\"/>";
				#src/TSMailer.hx:140: characters 5-44
				$debug = ($img_name??'null') . " mime " . ($mime??'null');
				#src/TSMailer.hx:146: characters 6-76
				$b = (array_key_exists("stringToReplace", $this->params->data) ? \StringTools::replace($b, ($this->params->data["stringToReplace"] ?? null), $imgHtml) : \StringTools::replace($b, "</body>", ($imgHtml??'null') . "</body>"));
			}
			#src/TSMailer.hx:161: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:161: characters 4-51
			$tmp->setBody($b, "text/html");
		} else {
			#src/TSMailer.hx:165: characters 4-14
			$this->shouldSend = false;
			#src/TSMailer.hx:166: characters 4-38
			$this->_result->additional = ($this->_result->additional??'null') . " No BODY; ";
		}
	}

	/**
	 * @return void
	 */
	public function prepareCc () {
		#src/TSMailer.hx:187: characters 3-15
		$cc = new HxAnon();
		#src/TSMailer.hx:188: lines 188-198
		if (array_key_exists("cc_email", $this->params->data)) {
			#src/TSMailer.hx:190: characters 4-51
			$t = HxString::split(($this->params->data["cc_email"] ?? null), ",");
			#src/TSMailer.hx:193: lines 193-196
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:193: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:193: lines 193-196
				++$_g;
				#src/TSMailer.hx:195: characters 5-33
				\Reflect::setField($cc, $i, "");
			}
			#src/TSMailer.hx:197: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:197: characters 4-67
			$tmp->setCc(((array)($cc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareFrom () {
		#src/TSMailer.hx:218: characters 3-17
		$from = new HxAnon();
		#src/TSMailer.hx:220: lines 220-224
		if (!array_key_exists("from_email", $this->params->data)) {
			#src/TSMailer.hx:222: characters 4-48
			$this->params->data["from_email"] = "qook@salt.ch";
			#src/TSMailer.hx:223: characters 4-57
			$this->params->data["from_full_name"] = "qook troubleshoooting";
		}
		#src/TSMailer.hx:225: characters 3-135
		\Reflect::setField($from, ($this->params->data["from_email"] ?? null), (array_key_exists("from_full_name", $this->params->data) ? ($this->params->data["from_full_name"] ?? null) : ""));
		#src/TSMailer.hx:226: characters 15-22
		$tmp = $this->message;
		#src/TSMailer.hx:226: characters 3-70
		$tmp->setFrom(((array)($from)));
	}

	/**
	 * @return mixed
	 */
	public function prepareSubject () {
		#src/TSMailer.hx:231: characters 27-42
		$tmp = "Swift_Message";
		#src/TSMailer.hx:231: characters 3-71
		return new $tmp(($this->params->data["subject"] ?? null));
	}

	/**
	 * @return void
	 */
	public function prepareTo () {
		#src/TSMailer.hx:203: characters 3-15
		$to = new HxAnon();
		#src/TSMailer.hx:204: lines 204-213
		if (array_key_exists("to_email", $this->params->data)) {
			#src/TSMailer.hx:206: characters 4-127
			\Reflect::setField($to, ($this->params->data["to_email"] ?? null), (array_key_exists("to_full_name", $this->params->data) ? ($this->params->data["to_full_name"] ?? null) : ""));
			#src/TSMailer.hx:207: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:207: characters 4-67
			$tmp->setTo(((array)($to)));
		} else {
			#src/TSMailer.hx:211: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:212: characters 4-36
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
