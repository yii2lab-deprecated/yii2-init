<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;

class SetCoreDomain extends Base {

	public function run()
	{
		$this->loadDefault('domain');
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$this->replaceContentList([
			'_CORE_DOMAIN_PLACEHOLDER_' => $config['core'],
		]);
	}

	private function userInput() {
		$config = $this->default;
		$config['core'] = Enter::display('Core api domain '. $this->renderDefault('core'));
		$config = $this->setDefault($config);
		return $config;
	}

}
