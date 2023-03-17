<?php
/**
 * Haxe source file: C:\HaxeToolkit\haxe\std/haxe/CallStack.hx
 */

namespace haxe\_CallStack;

use \php\Boot;
use \haxe\StackItem;

final class CallStack_Impl_ {
	/**
	 * @param \StringBuf $b
	 * @param StackItem $s
	 * 
	 * @return void
	 */
	public static function itemToString ($b, $s) {
		#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:156: lines 156-183
		$__hx__switch = ($s->index);
		if ($__hx__switch === 0) {
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:158: characters 5-26
			$b->add("a C function");
		} else if ($__hx__switch === 1) {
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:159: characters 16-17
			$m = $s->params[0];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:160: characters 5-21
			$b->add("module ");
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:161: characters 5-13
			$b->add($m);
		} else if ($__hx__switch === 2) {
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:162: characters 17-18
			$s1 = $s->params[0];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:162: characters 20-24
			$file = $s->params[1];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:162: characters 26-30
			$line = $s->params[2];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:162: characters 32-35
			$col = $s->params[3];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:163: lines 163-166
			if ($s1 !== null) {
				#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:164: characters 6-24
				CallStack_Impl_::itemToString($b, $s1);
				#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:165: characters 6-17
				$b->add(" (");
			}
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:167: characters 5-16
			$b->add($file);
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:168: characters 5-20
			$b->add(" line ");
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:169: characters 5-16
			$b->add($line);
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:170: lines 170-173
			if ($col !== null) {
				#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:171: characters 6-23
				$b->add(" column ");
				#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:172: characters 6-16
				$b->add($col);
			}
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:174: lines 174-175
			if ($s1 !== null) {
				#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:175: characters 6-16
				$b->add(")");
			}
		} else if ($__hx__switch === 3) {
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:176: characters 16-21
			$cname = $s->params[0];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:176: characters 23-27
			$meth = $s->params[1];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:177: characters 5-47
			$b->add(($cname === null ? "<unknown>" : $cname));
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:178: characters 5-15
			$b->add(".");
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:179: characters 5-16
			$b->add($meth);
		} else if ($__hx__switch === 4) {
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:180: characters 23-24
			$n = $s->params[0];
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:181: characters 5-30
			$b->add("local function #");
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:182: characters 5-13
			$b->add($n);
		}
	}

	/**
	 * Returns a representation of the stack as a printable string.
	 * 
	 * @param StackItem[]|\Array_hx $stack
	 * 
	 * @return string
	 */
	public static function toString ($stack) {
		#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:72: characters 3-27
		$b = new \StringBuf();
		#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:73: lines 73-76
		$_g = 0;
		$_g1 = $stack;
		while ($_g < $_g1->length) {
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:73: characters 8-9
			$s = ($_g1->arr[$_g] ?? null);
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:73: lines 73-76
			++$_g;
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:74: characters 4-27
			$b->add("\x0ACalled from ");
			#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:75: characters 4-22
			CallStack_Impl_::itemToString($b, $s);
		}
		#C:\HaxeToolkit\haxe\std/haxe/CallStack.hx:77: characters 3-22
		return $b->b;
	}
}

Boot::registerClass(CallStack_Impl_::class, 'haxe._CallStack.CallStack_Impl_');
