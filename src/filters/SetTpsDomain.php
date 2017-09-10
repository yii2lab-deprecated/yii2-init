<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;

class SetTpsDomain extends Base {

	public function run()
	{
		$this->loadDefault('domain');
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$this->replaceContentList([
			'_TPS_DOMAIN_PLACEHOLDER_' => $config['tps'],
		]);
	}

	private function userInput() {
		$config = $this->default;
		$config['tps'] = Enter::display('TPS api domain '. $this->renderDefault('tps'));
		$config = $this->setDefault($config);
		return $config;
	}

}
