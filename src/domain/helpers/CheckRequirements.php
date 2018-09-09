<?php

namespace yii2lab\init\domain\helpers;

use yii2lab\extension\console\helpers\Output;

class CheckRequirements {

	public static function run()
	{
		self::checkOpenSsl();
	}

	private static function checkOpenSsl()
	{
		if (!extension_loaded('openssl')) {
			Output::line('The OpenSSL PHP extension is required by Yii2.');
			die();
		}
	}
	
}
