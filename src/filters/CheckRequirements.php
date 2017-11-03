<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Output;

class CheckRequirements extends Base {

	public function run()
	{
		$this->checkOpenSsl();
	}

	private function checkOpenSsl()
	{
		if (!extension_loaded('openssl')) {
			Output::line('The OpenSSL PHP extension is required by Yii2.');
			die();
		}
	}
	
}
