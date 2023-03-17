<?php
/**
 */

namespace mail;

use \php\Boot;

/**
 * ...
 * @author bb
 */
class Results {
	/**
	 * @var string
	 */
	const FAILED = "failed";

}

Boot::registerClass(Results::class, 'mail.Results');
