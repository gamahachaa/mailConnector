<?php
/**
 */

use \php\Boot;
use \php\_Boot\HxString;

/**
 * The Std class provides standard methods for manipulating basic types.
 */
class Std {
	/**
	 * Converts a `String` to an `Int`.
	 * Leading whitespaces are ignored.
	 * If `x` starts with 0x or 0X, hexadecimal notation is recognized where the following digits may
	 * contain 0-9 and A-F.
	 * Otherwise `x` is read as decimal number with 0-9 being allowed characters. `x` may also start with
	 * a - to denote a negative value.
	 * In decimal mode, parsing continues until an invalid character is detected, in which case the
	 * result up to that point is returned. For hexadecimal notation, the effect of invalid characters
	 * is unspecified.
	 * Leading 0s that are not part of the 0x/0X hexadecimal notation are ignored, which means octal
	 * notation is not supported.
	 * If `x` is null, the result is unspecified.
	 * If `x` cannot be parsed as integer, the result is `null`.
	 * 
	 * @param string $x
	 * 
	 * @return int
	 */
	public static function parseInt ($x) {
		#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:55: lines 55-70
		if (is_numeric($x)) {
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:56: characters 4-31
			return intval($x, 10);
		} else {
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:58: characters 4-23
			$x = ltrim($x);
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:59: characters 4-54
			$firstCharIndex = (mb_substr($x, 0, 1) === "-" ? 1 : 0);
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:60: characters 4-53
			$firstCharCode = HxString::charCodeAt($x, $firstCharIndex);
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:61: lines 61-63
			if (!(($firstCharCode !== null) && ($firstCharCode >= 48) && ($firstCharCode <= 57))) {
				#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:62: characters 5-16
				return null;
			}
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:64: characters 21-49
			$index = $firstCharIndex + 1;
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:64: characters 4-50
			$secondChar = ($index < 0 ? "" : mb_substr($x, $index, 1));
			#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:65: lines 65-69
			if (($secondChar === "x") || ($secondChar === "X")) {
				#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:66: characters 5-31
				return intval($x, 0);
			} else {
				#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:68: characters 5-32
				return intval($x, 10);
			}
		}
	}

	/**
	 * Converts any value to a String.
	 * If `s` is of `String`, `Int`, `Float` or `Bool`, its value is returned.
	 * If `s` is an instance of a class and that class or one of its parent classes has
	 * a `toString` method, that method is called. If no such method is present, the result
	 * is unspecified.
	 * If `s` is an enum constructor without argument, the constructor's name is returned. If
	 * arguments exists, the constructor's name followed by the String representations of
	 * the arguments is returned.
	 * If `s` is a structure, the field names along with their values are returned. The field order
	 * and the operator separating field names and values are unspecified.
	 * If s is null, "null" is returned.
	 * 
	 * @param mixed $s
	 * 
	 * @return string
	 */
	public static function string ($s) {
		#C:\HaxeToolkit\haxe\std/php/_std/Std.hx:47: characters 3-27
		return Boot::stringify($s);
	}
}

Boot::registerClass(Std::class, 'Std');
