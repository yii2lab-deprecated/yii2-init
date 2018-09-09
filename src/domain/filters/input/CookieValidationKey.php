<?php

namespace yii2lab\init\domain\filters\input;

use yii\base\Security;
use yii2lab\extension\console\helpers\Output;
use yii2lab\extension\scenario\base\BaseScenario;

class CookieValidationKey extends BaseScenario {
	
	public $length = 32;
	public $apps = [
		'frontend',
		'backend',
	];
	
	public function run() {
		$config = $this->getData();
		Output::line();
		$keyList = $this->getKeyForApps();
		$config['cookieValidationKey'] = $keyList;
		$this->setData($config);
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
