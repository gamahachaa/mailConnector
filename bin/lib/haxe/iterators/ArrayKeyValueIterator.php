<?php
/**
 * Generated by Haxe 4.1.5
 */

namespace haxe\iterators;

use \php\Boot;

class ArrayKeyValueIterator {
	/**
	 * @var \Array_hx
	 */
	public $array;

	/**
	 * @param \Array_hx $array
	 * 
	 * @return void
	 */
	public function __construct ($array) {
		#C:\HaxeToolkit\haxe\std/haxe/iterators/ArrayKeyValueIterator.hx:32: characters 3-21
		$this->array = $array;
	}
}

Boot::registerClass(ArrayKeyValueIterator::class, 'haxe.iterators.ArrayKeyValueIterator');
