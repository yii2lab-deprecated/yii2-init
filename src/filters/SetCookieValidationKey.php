<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Output;

class SetCookieValidationKey extends Base {

	public $placeholderMask = '{name}_COOKIE_VALIDATION_KEY';

	public function run()
	{
		foreach ($this->paths as $file) {
			Output::line("   generate cookie validation key in $file");
			$replacement = $this->getKeyForApps();
			$this->replaceContentList($replacement);
		}
	}

	private function getKeyForApps() {
		$config = [];
		$appList = $this->initInstance->getConfigItem('enum.app');
		foreach($appList as $app) {
			$config[$app] = $this->generateKey();
		}
		$replacement = $this->generateReplacement($config);
		return $replacement;
	}

	private function generateKey()
	{
		$length = $this->initInstance->getConfigItem('system.cookieValidationKeyLength');
		$bytes = openssl_random_pseudo_bytes($length);
		$base64 = base64_encode($bytes);
		$key = substr($base64, 0, $length);
		$key = strtr($key, '+/=', '_-.');
		return $key;
	}
}
