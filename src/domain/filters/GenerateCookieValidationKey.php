<?php

namespace yii2lab\init\domain\filters;

use yii\base\Security;
use yii2lab\console\helpers\Output;
use yii2lab\init\domain\base\PlaceholderBaseFilter;
use yii2lab\designPattern\command\interfaces\CommandInterface;

class GenerateCookieValidationKey extends PlaceholderBaseFilter implements CommandInterface {

	public $placeholderMask = '{name}_COOKIE_VALIDATION_KEY';
	public $length = 32;
	public $apps = [
		'frontend',
		'backend',
	];

	public function run()
	{
		foreach ($this->paths as $file) {
			Output::line("generate cookie validation key in $file");
			$replacement = $this->getKeyForApps();
			$this->placeholder->replaceContentList($replacement);
		}
	}

	private function getKeyForApps() {
		$config = [];
		foreach($this->apps as $app) {
			$config[$app] = $this->generateKey();
		}
		$replacement = $this->placeholder->generateReplacement($config);
		return $replacement;
	}

	private function generateKey()
	{
		$security = new Security;
		$key = $security->generateRandomString($this->length);
		return $key;
	}
}
