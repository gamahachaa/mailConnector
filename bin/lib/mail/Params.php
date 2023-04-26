<?php
/**
 */

namespace mail;

use \php\Boot;

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
	const IMAGE_FULL_NAME = "imagefullname";
	/**
	 * @var string
	 */
	const MINE_TYPE_GIF = "image/gif";
	/**
	 * @var string
	 */
	const MINE_TYPE_JPG = "image/jpeg";
	/**
	 * @var string
	 */
	const MINE_TYPE_PNG = "image/png";
	/**
	 * @var string
	 */
	const MINE_UNKNOWN = "application/unknown";
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
