<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Output;

class SetCookieValidationKey extends Base {

	public function run()
	{
		foreach ($this->paths as $file) {
			Output::line("   generate cookie validation key in $file");
			$replacement = $this->getKeyForApps();
			$this->replaceContentList($replacement);
		}
	}

	private function getKeyForApps() {
		$replacement = [];
		foreach($this->appList as $app) {
			$placeholder = '_' . strtoupper($app) . '_COOKIE_VALIDATION_KEY_PLACEHOLDER_';
			$replacement[$placeholder] = $this->generateCookieValidationKey();
		}
		return $replacement;
	}

	private function generateCookieValidationKey($length = 32)
	{
		$bytes = openssl_random_pseudo_bytes($length);
		$key = strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
		return $key;
	}
}
