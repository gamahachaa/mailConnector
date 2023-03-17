<?php
/**
 * Haxe source file: C:\HaxeToolkit\haxe\lib\utils/utils/mail/Params.hx
 */

namespace mail;

use \php\Boot;

/**
 * ...
 * @author bb
 */
class Params {
	/**
	 * @var string
	 */
	const BCC_EMAIL = "bcc_email";
	/**
	 * @var string
	 */
	const BODY = "body";
	/**
	 * @var string
	 */
	const CC_EMAIL = "cc_email";
	/**
	 * @var string
	 */
	const FROM_FULL_MAIL = "from_full_name";
	/**
	 * @var string
	 */
	const FROM_MAIL = "from_email";
	/**
	 * @var string
	 */
	const IMAGE = "image";
	/**
	 * @var string
	 */
	const IMAGE_EXT = "imageExt";
	/**
	 * @var string
	 */
	const STRING_TO_REPLACE = "stringToReplace";
	/**
	 * @var string
	 */
	const SUBJECT = "subject";
	/**
	 * @var string
	 */
	const TO_EMAIL = "to_email";
	/**
	 * @var string
	 */
	const TO_FULL_NAME = "to_full_name";

}

Boot::registerClass(Params::class, 'mail.Params');
