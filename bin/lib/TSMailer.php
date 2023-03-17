<?php
/**
 */

use \haxe\io\_BytesData\Container;
use \php\_Boot\HxAnon;
use \php\Boot;
use \php\Web;
use \haxe\Json;
use \php\_Boot\HxString;
use \haxe\Exception as HaxeException;
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
		#src/TSMailer.hx:42: characters 3-22
		require_once("vendor/autoload.php");
		$tmp = "Swift_SmtpTransport";
		$this->transport = new $tmp("smtp.salt.ch", 25);
		$tmp = $this->transport;
		$tmp->setUsername("bbaudry");
		$tmp = "Swift_Mailer";
		$this->mailer = new $tmp($this->transport);
		#src/TSMailer.hx:44: characters 3-78
		$this->_result = new _HxAnon_TSMailer0("failed", null, "", "");
		#src/TSMailer.hx:46: characters 3-23
		$this->route = Web::getURI();
		#src/TSMailer.hx:47: characters 3-27
		$this->params = Web::getParams();
		#src/TSMailer.hx:48: characters 3-20
		$this->shouldSend = true;
		#src/TSMailer.hx:49: characters 30-45
		$tmp = "Swift_Message";
		#src/TSMailer.hx:49: characters 3-57
		$this->message = new $tmp("ERRORED");
		#src/TSMailer.hx:53: lines 53-80
		if (array_key_exists("subject", $this->params->data)) {
			#src/TSMailer.hx:55: lines 55-73
			try {
				#src/TSMailer.hx:57: characters 5-16
				$this->prepareTo();
				#src/TSMailer.hx:59: characters 5-18
				$this->prepareFrom();
				#src/TSMailer.hx:60: characters 5-16
				$this->prepareCc();
				#src/TSMailer.hx:61: characters 5-17
				$this->prepareBcc();
				#src/TSMailer.hx:62: characters 5-19
				$this->prepareImage();
				#src/TSMailer.hx:63: characters 5-32
				$this->prepareBody($this->prepareImage());
				#src/TSMailer.hx:64: characters 26-52
				$tmp = ($this->params->data["subject"] ?? null);
				#src/TSMailer.hx:64: characters 5-52
				$this->_result->additional = $tmp;
				#src/TSMailer.hx:65: characters 21-47
				$tmp = ($this->params->data["subject"] ?? null);
				#src/TSMailer.hx:65: characters 5-47
				$this->_result->debug = $tmp;
				#src/TSMailer.hx:66: characters 5-57
				$this->message = $this->prepareSubject(($this->params->data["subject"] ?? null));
				#src/TSMailer.hx:67: characters 5-28
				$this->_result->debug = $this->message;
			} catch(\Throwable $_g) {
				#src/TSMailer.hx:70: characters 11-12
				$e = HaxeException::caught($_g);
				#src/TSMailer.hx:72: characters 5-30
				$this->_result->debug = $e->get_message();
			}
		} else {
			#src/TSMailer.hx:78: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:79: characters 4-40
			$this->_result->additional = ($this->_result->additional??'null') . "No subject; ";
		}
		#src/TSMailer.hx:82: lines 82-106
		if ($this->shouldSend) {
			#src/TSMailer.hx:85: characters 29-35
			$tmp = $this->mailer;
			#src/TSMailer.hx:85: characters 4-54
			$result = $tmp->send($this->message);
			#src/TSMailer.hx:86: lines 86-97
			if ($result) {
				#src/TSMailer.hx:88: characters 5-31
				$this->_result->status = "success";
			} else {
				#src/TSMailer.hx:94: characters 5-30
				$this->_result->status = "failed";
				#src/TSMailer.hx:95: characters 5-38
				$this->_result->error = "transport issue";
			}
		} else {
			#src/TSMailer.hx:103: characters 4-29
			$this->_result->status = "failed";
			#src/TSMailer.hx:104: characters 4-42
			$this->_result->error = "missing key variable";
		}
		#src/TSMailer.hx:107: characters 3-40
		echo(\Std::string(Json::phpJsonEncode($this->_result, null, null)));
	}

	/**
	 * @return void
	 */
	public function createSwiftMailer () {
		#src/TSMailer.hx:220: characters 3-58
		require_once("vendor/autoload.php");
		#src/TSMailer.hx:222: characters 32-53
		$tmp = "Swift_SmtpTransport";
		#src/TSMailer.hx:222: characters 3-74
		$this->transport = new $tmp("smtp.salt.ch", 25);
		#src/TSMailer.hx:223: characters 15-24
		$tmp = $this->transport;
		#src/TSMailer.hx:223: characters 3-52
		$tmp->setUsername("bbaudry");
		#src/TSMailer.hx:226: characters 29-43
		$tmp = "Swift_Mailer";
		#src/TSMailer.hx:226: characters 3-55
		$this->mailer = new $tmp($this->transport);
	}

	/**
	 * @return void
	 */
	public function prepareBcc () {
		#src/TSMailer.hx:140: characters 3-16
		$bcc = new HxAnon();
		#src/TSMailer.hx:141: lines 141-150
		if (array_key_exists("bcc_email", $this->params->data)) {
			#src/TSMailer.hx:143: characters 4-52
			$t = HxString::split(($this->params->data["bcc_email"] ?? null), ",");
			#src/TSMailer.hx:144: lines 144-147
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:144: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:144: lines 144-147
				++$_g;
				#src/TSMailer.hx:146: characters 5-34
				\Reflect::setField($bcc, $i, "");
			}
			#src/TSMailer.hx:149: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:149: characters 4-69
			$tmp->setBcc(((array)($bcc)));
		}
	}

	/**
	 * @param string $image
	 * 
	 * @return void
	 */
	public function prepareBody ($image = null) {
		#src/TSMailer.hx:112: lines 112-135
		if (array_key_exists("body", $this->params->data)) {
			#src/TSMailer.hx:114: characters 4-39
			$body = ($this->params->data["body"] ?? null);
			#src/TSMailer.hx:115: lines 115-128
			if ($image !== null) {
				#src/TSMailer.hx:117: characters 5-49
				$img = "<img src=\"" . ($image??'null') . "\" alt=\"Image\"/>";
				#src/TSMailer.hx:120: characters 6-75
				$body = (array_key_exists("stringToReplace", $this->params->data) ? \StringTools::replace($body, ($this->params->data["stringToReplace"] ?? null), $img) : \StringTools::replace($body, "</body>", ($img??'null') . "</body>"));
			} else {
				#src/TSMailer.hx:127: characters 6-73
				\StringTools::replace($body, ($this->params->data["stringToReplace"] ?? null), "");
			}
			#src/TSMailer.hx:129: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:129: characters 4-54
			$tmp->setBody($body, "text/html");
		} else {
			#src/TSMailer.hx:133: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:134: characters 4-38
			$this->_result->additional = ($this->_result->additional??'null') . " No BODY; ";
		}
	}

	/**
	 * @return void
	 */
	public function prepareCc () {
		#src/TSMailer.hx:155: characters 3-15
		$cc = new HxAnon();
		#src/TSMailer.hx:156: lines 156-166
		if (array_key_exists("cc_email", $this->params->data)) {
			#src/TSMailer.hx:158: characters 4-51
			$t = HxString::split(($this->params->data["cc_email"] ?? null), ",");
			#src/TSMailer.hx:161: lines 161-164
			$_g = 0;
			while ($_g < $t->length) {
				#src/TSMailer.hx:161: characters 9-10
				$i = ($t->arr[$_g] ?? null);
				#src/TSMailer.hx:161: lines 161-164
				++$_g;
				#src/TSMailer.hx:163: characters 5-33
				\Reflect::setField($cc, $i, "");
			}
			#src/TSMailer.hx:165: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:165: characters 4-67
			$tmp->setCc(((array)($cc)));
		}
	}

	/**
	 * @return void
	 */
	public function prepareFrom () {
		#src/TSMailer.hx:186: characters 3-17
		$from = new HxAnon();
		#src/TSMailer.hx:188: lines 188-192
		if (!array_key_exists("from_email", $this->params->data)) {
			#src/TSMailer.hx:190: characters 4-48
			$this->params->data["from_email"] = "qook@salt.ch";
			#src/TSMailer.hx:191: characters 4-57
			$this->params->data["from_full_name"] = "qook troubleshoooting";
		}
		#src/TSMailer.hx:193: characters 3-125
		\Reflect::setField($from, ($this->params->data["from_email"] ?? null), (array_key_exists("from_full_name", $this->params->data) ? ($this->params->data["from_full_name"] ?? null) : ""));
		#src/TSMailer.hx:195: characters 15-22
		$tmp = $this->message;
		#src/TSMailer.hx:195: characters 3-40
		$tmp->setFrom($from);
	}

	/**
	 * @return string
	 */
	public function prepareImage () {
		#src/TSMailer.hx:205: characters 3-30
		$embeded = null;
		#src/TSMailer.hx:206: lines 206-213
		if (array_key_exists("image", $this->params->data)) {
			#src/TSMailer.hx:208: characters 13-99
			$ext = (array_key_exists("imageExt", $this->params->data) ? ($this->params->data["imageExt"] ?? null) : "image/png");
			#src/TSMailer.hx:209: characters 19-58
			$str = ($this->params->data["image"] ?? null);
			$s = base64_decode($str, true);
			$imgData = strlen($s);
			#src/TSMailer.hx:209: characters 4-59
			$imgData1 = new Bytes($imgData, new Container($s));
			#src/TSMailer.hx:210: characters 38-51
			$tmp = "Swift_Image";
			#src/TSMailer.hx:210: characters 4-69
			$swiftImage = new $tmp($imgData1, $ext);
			#src/TSMailer.hx:211: characters 26-33
			$tmp = $this->message;
			#src/TSMailer.hx:211: characters 4-55
			$embeded = $tmp->embed($swiftImage);
		}
		#src/TSMailer.hx:214: characters 3-17
		return $embeded;
	}

	/**
	 * @param string $s
	 * 
	 * @return mixed
	 */
	public function prepareSubject ($s) {
		#src/TSMailer.hx:201: characters 27-42
		$tmp = "Swift_Message";
		#src/TSMailer.hx:201: characters 3-46
		return new $tmp($s);
	}

	/**
	 * @return void
	 */
	public function prepareTo () {
		#src/TSMailer.hx:171: characters 3-15
		$to = new HxAnon();
		#src/TSMailer.hx:172: lines 172-181
		if (array_key_exists("to_email", $this->params->data)) {
			#src/TSMailer.hx:174: characters 4-127
			\Reflect::setField($to, ($this->params->data["to_email"] ?? null), (array_key_exists("to_full_name", $this->params->data) ? ($this->params->data["to_full_name"] ?? null) : ""));
			#src/TSMailer.hx:175: characters 16-23
			$tmp = $this->message;
			#src/TSMailer.hx:175: characters 4-67
			$tmp->setTo(((array)($to)));
		} else {
			#src/TSMailer.hx:179: characters 4-22
			$this->shouldSend = false;
			#src/TSMailer.hx:180: characters 4-36
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
