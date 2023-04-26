<?php
/**
 */

namespace haxe\crypto;

use \php\Boot;

class Base64 {
	/**
	 * @var array
	 */
	static public $NORMAL_62_63;
	/**
	 * @var array
	 */
	static public $URL_62_63;


	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;


		self::$NORMAL_62_63 = ["+", "/"];
		self::$URL_62_63 = ["-", "_"];
	}
}

Boot::registerClass(Base64::class, 'haxe.crypto.Base64');
Base64::__hx__init();
