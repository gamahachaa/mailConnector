<?php
/**
 * Haxe source file: C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx
 */

namespace haxe;

use \php\Boot;
use \php\_Boot\HxString;

/**
 * Do not use manually.
 */
class NativeStackTrace {
	/**
	 * @var \Closure
	 * If defined this function will be used to transform call stack entries.
	 * @param String - generated php file name.
	 * @param Int - Line number in generated file.
	 */
	static public $mapPosition;

	/**
	 * @param mixed[] $nativeTrace
	 * @param \Throwable $e
	 * 
	 * @return mixed[]
	 */
	public static function complementTrace ($nativeTrace, $e) {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:106: characters 18-49
		$this1 = [];
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:106: characters 3-50
		$thrownAt = $this1;
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:107: characters 3-28
		$thrownAt["function"] = "";
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:108: characters 3-33
		$thrownAt["line"] = $e->getLine();
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:109: characters 3-33
		$thrownAt["file"] = $e->getFile();
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:110: characters 3-25
		$thrownAt["class"] = "";
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:111: characters 22-39
		$this1 = [];
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:111: characters 3-39
		$thrownAt["args"] = $this1;
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:112: characters 3-46
		\array_unshift($nativeTrace, $thrownAt);
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:113: characters 3-21
		return $nativeTrace;
	}

	/**
	 * @param mixed[] $native
	 * @param int $skip
	 * 
	 * @return StackItem[]|\Array_hx
	 */
	public static function toHaxe ($native, $skip = 0) {
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:61: lines 61-103
		if ($skip === null) {
			$skip = 0;
		}
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:62: characters 3-19
		$result = new \Array_hx();
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:63: characters 3-36
		$count = \count($native);
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:65: characters 13-17
		$_g = 0;
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:65: characters 17-22
		$_g1 = $count;
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:65: lines 65-100
		while ($_g < $_g1) {
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:65: characters 13-22
			$i = $_g++;
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:66: lines 66-68
			if ($skip > $i) {
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:67: characters 5-13
				continue;
			}
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:70: characters 4-26
			$entry = $native[$i];
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:71: characters 4-20
			$item = null;
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:73: lines 73-87
			if (($i + 1) < $count) {
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:74: characters 5-30
				$next = $native[$i + 1];
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:76: lines 76-77
				if (!isset($next["function"])) {
					#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:77: characters 6-27
					$next["function"] = "";
				}
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:78: lines 78-79
				if (!isset($next["class"])) {
					#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:79: characters 6-24
					$next["class"] = "";
				}
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:81: lines 81-86
				if (HxString::indexOf($next["function"], "{closure}") >= 0) {
					#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:82: characters 6-28
					$item = StackItem::LocalFunction();
				} else if ((\strlen($next["class"]) > 0) && (\strlen($next["function"]) > 0)) {
					#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:84: characters 6-49
					$cls = Boot::getClassName($next["class"]);
					#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:85: characters 6-42
					$item = StackItem::Method($cls, $next["function"]);
				}
			}
			#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:88: lines 88-99
			if (isset($entry["file"])) {
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:89: lines 89-95
				if (NativeStackTrace::$mapPosition !== null) {
					#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:90: characters 6-58
					$pos = (NativeStackTrace::$mapPosition)($entry["file"], $entry["line"]);
					#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:91: lines 91-94
					if (($pos !== null) && ($pos->source !== null) && ($pos->originalLine !== null)) {
						#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:92: characters 7-33
						$entry["file"] = $pos->source;
						#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:93: characters 7-39
						$entry["line"] = $pos->originalLine;
					}
				}
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:96: characters 5-61
				$x = StackItem::FilePos($item, $entry["file"], $entry["line"]);
				$result->arr[$result->length++] = $x;
			} else if ($item !== null) {
				#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:98: characters 5-22
				$result->arr[$result->length++] = $item;
			}
		}
		#C:\HaxeToolkit\haxe\std/php/_std/haxe/NativeStackTrace.hx:102: characters 3-16
		return $result;
	}
}

Boot::registerClass(NativeStackTrace::class, 'haxe.NativeStackTrace');
