<?php

namespace yii2lab\init\filters;

use yii\base\Security;
use yii2lab\console\helpers\Output;
use yii2lab\init\base\PlaceholderBaseFilter;
use yii2lab\init\helpers\Config;

class GenerateCookieValidationKey extends PlaceholderBaseFilter {

	public $placeholderMask = '{name}_COOKIE_VALIDATION_KEY';

	public function run()
	{
		foreach ($this->paths as $file) {
			Output::line("generate cookie validation key in $file");
			$replacement = $this->getKeyForApps();
			$this->replaceContentList($replacement);
		}
	}

	private function getKeyForApps() {
		$config = [];
		$appList = Config::one('enum.app');
		foreach($appList as $app) {
			$config[$app] = $this->generateKey();
		}
		$replacement = $this->generateReplacement($config);
		return $replacement;
	}

	private function generateKey()
	{
		$length = Config::one('system.cookieValidationKeyLength');
		$security = new Security;
		$key = $security->generateRandomString($length);
		return $key;
	}
}
