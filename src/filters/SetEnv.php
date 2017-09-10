<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Question;

class SetEnv extends Base {

	public function run()
	{
		$this->loadDefault('env');
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$this->replaceContentList([
			'_YII_ENV_PLACEHOLDER_' => $config['env'],
			'_YII_DEBUG_PLACEHOLDER_' => $config['debug'],
		]);
	}

	private function userInput() {
		$config = $this->default;
		$config['env'] = Question::display('Select env ' . $this->renderDefault('env'), $this->initInstance->getConfigItem('enum.env'));
		$config = $this->setDefault($config);
		$config['debug'] = $config['env'] == 'prod' ? 'false' : 'true';
		return $config;
	}
}
