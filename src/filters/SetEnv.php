<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Question;

class SetEnv extends Base {

	public $placeholderMask = 'YII_{name}';

	public function run()
	{
		$this->loadDefault('env');
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$replacement = $this->generateReplacement($config);
		$this->replaceContentList($replacement);
	}

	private function userInput() {
		$config = $this->default;
		$config['env'] = Question::display('Select env ' . $this->renderDefault('env'), $this->initInstance->getConfigItem('enum.env'));
		$config = $this->setDefault($config);
		$config['debug'] = $config['env'] == 'prod' ? 'false' : 'true';
		return $config;
	}
}
