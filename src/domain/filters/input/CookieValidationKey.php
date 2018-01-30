<?php

namespace yii2lab\init\domain\filters\input;

use yii\base\Security;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\filter\interfaces\FilterInterface;

class CookieValidationKey implements FilterInterface {
	
	public $length = 32;
	public $apps = [
		'frontend',
		'backend',
	];
	
	public function run($config)
	{
		Output::line();
		$keyList = $this->getKeyForApps();
		$config['cookieValidationKey'] = $keyList;
		return $config;
	}
	
	private function getKeyForApps() {
		$config = [];
		foreach($this->apps as $app) {
			$config[$app] = $this->generateKey();
			Output::line("generate cookie validation key for $app");
		}
		return $config;
	}
	
	private function generateKey()
	{
		$security = new Security;
		$key = $security->generateRandomString($this->length);
		return $key;
	}
	
}
