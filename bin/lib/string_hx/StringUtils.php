<?php
/**
 */

namespace string_hx;

use \php\_Boot\HxAnon;
use \php\Boot;
use \php\_Boot\HxString;

/**
 * ...
 * @author bb
 */
class StringUtils {
	/**
	 * @var string
	 */
	const LINEFEEDS_N = "\x0A";
	/**
	 * @var string
	 */
	const LINEFEEDS_R = "\x0D";
	/**
	 * @var string
	 */
	const LINEFEEDS_RN = "\x0D\x0A";

	/**
	 * @param string $id
	 * 
	 * @return string
	 */
	public static function buildMarilynLink ($id) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:60: characters 3-105
		return "<a href=\"https://customercare.salt.ch/admin/contracts/customer/?q=" . (HxString::split($id, " ")->join("")??'null') . "\">" . ($id??'null') . "</a>";
	}

	/**
	 * @param string $id
	 * 
	 * @return string
	 */
	public static function buildSOLink ($id) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:55: characters 3-130
		return "<a href=\"https://cs.salt.ch/scripts/ticket.fcgi?_sf=0&action=doScreenDefinition&idString=viewCase&entryId=" . ($id??'null') . "\">" . ($id??'null') . "</a>";
	}

	/**
	 * @param string $voip
	 * @param string $contractor
	 * 
	 * @return string
	 */
	public static function buildVtiProneLink ($voip, $contractor) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:65: characters 3-145
		return "<a href=\"https://vti.salt.ch/index.php?module=Contractors&action=BasicAjax&mode=redirectToContractor&phone=" . ($voip??'null') . "\">" . ($contractor??'null') . "</a>";
	}

	/**
	 * @param string $s
	 * @param string $tag
	 * 
	 * @return object
	 */
	public static function getTags ($s, $tag) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:103: characters 3-80
		return new _HxAnon_StringUtils0(HxString::indexOf($s, "<" . ($tag??'null') . ">"), HxString::indexOf($s, "</" . ($tag??'null') . ">") + mb_strlen(("</" . ($tag??'null') . ">")));
	}

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function intlToLocalMSISDN ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:15: characters 3-27
		return "0" . (\mb_substr($s, 2, null)??'null');
	}

	/**
	 * @param string $s
	 * 
	 * @return bool
	 */
	public static function isBlank ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:95: characters 3-24
		return \trim($s) === "";
	}

	/**
	 * @param string $s
	 * @param string $defaultText
	 * @param int $minimalLength
	 * 
	 * @return bool
	 */
	public static function isMinimalText ($s, $defaultText = "", $minimalLength = 2) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:87: characters 10-65
		if ($defaultText === null) {
			$defaultText = "";
		}
		if ($minimalLength === null) {
			$minimalLength = 2;
		}
		if (\trim($s) !== $defaultText) {
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:87: characters 37-49
			$_this = HxString::split($s, " ");
			$f = Boot::getStaticClosure(StringUtils::class, 'isNotBlank');
			$result = [];
			$data = $_this->arr;
			$_g_current = 0;
			$_g_length = \count($data);
			$_g_data = $data;
			while ($_g_current < $_g_length) {
				$item = $_g_data[$_g_current++];
				if ($f($item)) {
					$result[] = $item;
				}
			}
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:87: characters 37-65
			return \Array_hx::wrap($result)->length > $minimalLength;
		} else {
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:87: characters 10-65
			return false;
		}
	}

	/**
	 * @param string $s
	 * 
	 * @return bool
	 */
	public static function isNotBlank ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:99: characters 3-21
		return \trim($s) !== "";
	}

	/**
	 * @param string $s
	 * @param string $lineFeed
	 * 
	 * @return string
	 */
	public static function lineFeedRemove ($s, $lineFeed = "\x0A") {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:39: characters 3-38
		if ($lineFeed === null) {
			$lineFeed = "\x0A";
		}
		return HxString::split($s, $lineFeed)->join(". ");
	}

	/**
	 * @param string $s
	 * @param string $lineFeed
	 * 
	 * @return string
	 */
	public static function lineFeedToHTMLbr ($s, $lineFeed = "\x0A") {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:31: characters 3-41
		if ($lineFeed === null) {
			$lineFeed = "\x0A";
		}
		return HxString::split($s, $lineFeed)->join("<br/>");
	}

	/**
	 * @param string $s
	 * @param string $sub
	 * 
	 * @return int
	 */
	public static function occurencesOf ($s, $sub) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:50: characters 3-33
		return HxString::split($s, $sub)->length - 1;
	}

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function phonSpaces ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:23: characters 3-23
		$t = HxString::split($s, "");
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:24: characters 3-19
		$t->insert(8, " ");
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:25: characters 3-19
		$t->insert(6, " ");
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:26: characters 3-19
		$t->insert(3, " ");
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:27: characters 3-20
		return $t->join("");
	}

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function removeBlankLines ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:35: characters 10-49
		$_this = HxString::split($s, "\x0A");
		$f = Boot::getStaticClosure(StringUtils::class, 'isNotBlank');
		$result = [];
		$data = $_this->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		$_g_data = $data;
		while ($_g_current < $_g_length) {
			$item = $_g_data[$_g_current++];
			if ($f($item)) {
				$result[] = $item;
			}
		}
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:35: characters 3-67
		return \Array_hx::wrap($result)->join("\x0A");
	}

	/**
	 * @param string $s
	 * @param string $tag
	 * 
	 * @return string
	 */
	public static function removeTagsAndContent ($s, $tag) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:107: characters 3-15
		$tmp = $s;
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:109: lines 109-115
		while (true) {
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:109: characters 10-26
			$inlobj_start = HxString::indexOf($tmp, "<" . ($tag??'null') . ">");
			$inlobj_end = HxString::indexOf($tmp, "</" . ($tag??'null') . ">") + mb_strlen(("</" . ($tag??'null') . ">"));
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:109: lines 109-115
			if (!($inlobj_start !== -1)) {
				break;
			}
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:111: characters 17-34
			$tmpSub_start = HxString::indexOf($tmp, "<" . ($tag??'null') . ">");
			$tmpSub_end = HxString::indexOf($tmp, "</" . ($tag??'null') . ">") + mb_strlen(("</" . ($tag??'null') . ">"));
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:113: characters 4-7
			$tmp = \StringTools::replace($tmp, HxString::substring($tmp, $tmpSub_start, $tmpSub_end), "");
		}
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:116: characters 3-13
		return $tmp;
	}

	/**
	 * @param string $s
	 * 
	 * @return string
	 */
	public static function removeWhite ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:19: characters 3-31
		return HxString::split($s, " ")->join("");
	}

	/**
	 * @param float $f
	 * 
	 * @return string
	 */
	public static function roundedFloat ($f) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:70: characters 3-27
		$ff = $f - (int)($f);
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:75: characters 3-43
		$add = (($ff > 0) && ($ff < 1) ? "0" : "");
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:79: characters 3-29
		return \Std::string($f) . ($add??'null');
	}

	/**
	 * @param string $s
	 * 
	 * @return object
	 */
	public static function strHexToRGBInt ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:120: characters 3-73
		$f = function ($e) {
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:120: characters 36-72
			if (mb_strlen($e) !== 6) {
				#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:120: characters 56-71
				return mb_strlen($e) === 8;
			} else {
				#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:120: characters 36-72
				return true;
			}
		};
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:121: characters 3-23
		$allgood = false;
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:122: lines 122-130
		$rgbString = (HxString::indexOf($s, "#") === 0 ? \mb_substr($s, 1, null) : (HxString::indexOf($s, "0x") === 0 ? \mb_substr($s, 2, null) : $s));
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:131: lines 131-137
		if ($f($rgbString)) {
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:133: characters 15-56
			$tmp = \Std::parseInt("0x" . (\mb_substr($rgbString, 0, 2)??'null'));
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:133: characters 61-102
			$tmp1 = \Std::parseInt("0x" . (\mb_substr($rgbString, 2, 2)??'null'));
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:133: characters 106-147
			$tmp2 = \Std::parseInt("0x" . (\mb_substr($rgbString, 4, 2)??'null'));
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:133: characters 4-264
			return new _HxAnon_StringUtils1($tmp, $tmp1, $tmp2, (int)(\floor(((\Std::parseInt("0x" . (\mb_substr($rgbString, 6, 2)??'null')) === null ? 0 : \Std::parseInt("0x" . (\mb_substr($rgbString, 6, 2)??'null')))) / 2 + 0.5)));
		} else {
			#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:136: characters 4-35
			return new _HxAnon_StringUtils1(0, 0, 0, 0);
		}
	}

	/**
	 * @param string $s
	 * 
	 * @return int
	 */
	public static function wordCount ($s) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:91: characters 10-41
		$_this = HxString::split($s, " ");
		$f = Boot::getStaticClosure(StringUtils::class, 'isNotBlank');
		$result = [];
		$data = $_this->arr;
		$_g_current = 0;
		$_g_length = \count($data);
		$_g_data = $data;
		while ($_g_current < $_g_length) {
			$item = $_g_data[$_g_current++];
			if ($f($item)) {
				$result[] = $item;
			}
		}
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:91: characters 3-48
		return \Array_hx::wrap($result)->length;
	}

	/**
	 * @param int $i
	 * 
	 * @return string
	 */
	public static function zeroLead ($i) {
		#C:\HaxeToolkit\haxe\lib\utils/utils/string/StringUtils.hx:83: characters 3-43
		return ((($i < 10 ? "0" : ""))??'null') . \Std::string($i);
	}
}

class _HxAnon_StringUtils0 extends HxAnon {
	function __construct($start, $end) {
		$this->start = $start;
		$this->end = $end;
	}
}

class _HxAnon_StringUtils1 extends HxAnon {
	function __construct($r, $g, $b, $alpha) {
		$this->r = $r;
		$this->g = $g;
		$this->b = $b;
		$this->alpha = $alpha;
	}
}

Boot::registerClass(StringUtils::class, 'string.StringUtils');
