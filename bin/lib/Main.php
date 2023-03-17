<?php
/**
 */

use \php\_Boot\HxAnon;
use \php\Boot;
use \haxe\Json;
use \haxe\Exception as HaxeException;

/**
 * ...
 * @author bbaudry
 */
class Main {
	/**
	 * @return void
	 */
	public static function main () {
		#src/Main.hx:16: characters 3-27
		$m = new Main();
	}

	/**
	 * @return void
	 */
	public function __construct () {
		#src/Main.hx:20: characters 3-75
		$result = new _HxAnon_Main0("failed", null, "initial");
		#src/Main.hx:21: lines 21-28
		try {
			#src/Main.hx:22: characters 4-41
			$mailer = new \TSMailer();
		} catch(\Throwable $_g) {
			#src/Main.hx:24: characters 9-10
			$e = HaxeException::caught($_g)->unwrap();
			#src/Main.hx:26: characters 4-20
			$result->error = $e;
			#src/Main.hx:27: characters 4-37
			echo(\Std::string(Json::phpJsonEncode($result, null, null)));
		}
	}
}

class _HxAnon_Main0 extends HxAnon {
	function __construct($status, $error, $additional) {
		$this->status = $status;
		$this->error = $error;
		$this->additional = $additional;
	}
}

Boot::registerClass(Main::class, 'Main');
