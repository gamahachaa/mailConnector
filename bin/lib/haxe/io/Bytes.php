<?php
/**
 */

namespace haxe\io;

use \haxe\io\_BytesData\Container;
use \php\Boot;

class Bytes {
	/**
	 * @var Container
	 */
	public $b;
	/**
	 * @var int
	 */
	public $length;

	/**
	 * @param int $length
	 * @param Container $b
	 * 
	 * @return void
	 */
	public function __construct ($length, $b) {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/io/Bytes.hx:34: characters 3-23
		$this->length = $length;
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/io/Bytes.hx:35: characters 3-13
		$this->b = $b;
	}

	/**
	 * @return string
	 */
	public function toString () {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/io/Bytes.hx:135: characters 3-11
		return $this->b->s;
	}

	public function __toString() {
		return $this->toString();
	}
}

Boot::registerClass(Bytes::class, 'haxe.io.Bytes');
