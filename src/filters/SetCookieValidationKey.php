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
			$placeholder = $this->getPlaceholderForApp($app);
			$replacement[$placeholder] = $this->generateKey();
		}
		return $replacement;
	}

	private function getPlaceholderForApp($app) {
		return '_' . strtoupper($app) . '_COOKIE_VALIDATION_KEY_PLACEHOLDER_';
	}

	private function generateKey()
	{
		$length = $this->initInstance->getConfigItem('system.cookieValidationKeyLength');
		$bytes = openssl_random_pseudo_bytes($length);
		$key = strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
		return $key;
	}
}
