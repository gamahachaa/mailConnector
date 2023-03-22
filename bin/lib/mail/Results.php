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
	/**
	 * @var string
	 */
	const SUCCESS = "success";

}

Boot::registerClass(Results::class, 'mail.Results');
