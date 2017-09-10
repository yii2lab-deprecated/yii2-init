<?php

namespace yii2lab\init\filters;

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
		$config['env'] = $this->showSelect('env', null, 'Select env');
		$config = $this->setDefault($config);
		$config['debug'] = $config['env'] == 'prod' ? 'false' : 'true';
		return $config;
	}
}
