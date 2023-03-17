<?php
/**
 * Haxe source file: C:\HaxeToolkit\haxe\std/php/Web.hx
 */

namespace php;

use \php\_Boot\HxString;
use \haxe\ds\StringMap;

/**
 * This class is used for accessing the local Web server and the current
 * client request and information.
 */
class Web {
	/**
	 * @var bool
	 */
	static public $isModNeko;

	/**
	 * Returns the GET and POST parameters.
	 * 
	 * @return StringMap
	 */
	public static function getParams () {
		#C:\HaxeToolkit\haxe\std/php/Web.hx:53: characters 3-62
		return Lib::hashOfAssociativeArray(\array_merge($_GET, $_POST));
	}

	/**
	 * Returns the original request URL (before any server internal redirections).
	 * 
	 * @return string
	 */
	public static function getURI () {
		#C:\HaxeToolkit\haxe\std/php/Web.hx:115: characters 3-41
		$s = $_SERVER["REQUEST_URI"];
		#C:\HaxeToolkit\haxe\std/php/Web.hx:116: characters 3-25
		return (HxString::split($s, "?")->arr[0] ?? null);
	}

	/**
	 * @internal
	 * @access private
	 */
	static public function __hx__init ()
	{
		static $called = false;
		if ($called) return;
		$called = true;

		#C:\HaxeToolkit\haxe\std/php/Web.hx:480: characters 3-27
		Web::$isModNeko = 0 !== \strncasecmp(\PHP_SAPI, "cli", 3);

	}
}

Boot::registerClass(Web::class, 'php.Web');
Web::__hx__init();
