<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;

class SetCoreDomain extends Base {

	public $root;
	public $paths;
	public $appList;
	public $default = [
		'domain' => 'api.core.yii',
	];

	public function run()
	{
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$this->replaceContentList([
			'_CORE_DOMAIN_PLACEHOLDER_' => $config['domain'],
		]);
	}

	private function userInput() {
		$config = $this->default;
		$config['domain'] = Enter::display('Core api domain '. $this->renderDefault('domain'));
		$config = $this->setDefault($config);
		return $config;
	}

}
