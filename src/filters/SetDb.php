<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;

class SetDb extends Base {

	public $placeholderMask = '{name}_DB';

	public function run()
	{
		$this->loadDefault('db');
		$config = [];
		if(Question::confirm('DB configure?')) {
			$config = $this->userInput();
			Output::arr($config);
		} else {
			$config = $this->setDefault($config);
		}
		$this->saveData($config);
	}

	private function saveData($config) {
		$replacement = $this->generateReplacement($config);
		$this->replaceContentList($replacement);
	}

	private function userInput() {
		$config = $this->default;
		$config['driver'] = $this->showSelect('driver');
		$config['host'] = $this->showInput('host');
		$config['username'] = $this->showInput('username');
		$config['password'] = $this->showInput('password');
		$config['dbname'] = $this->showInput('dbname');
		if($config['driver'] == 'pgsql') {
			$config['defaultSchema'] = $this->showInput('defaultSchema');
		}
		$config = $this->setDefault($config);
		return $config;
	}

}
