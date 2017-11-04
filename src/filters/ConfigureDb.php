<?php

namespace yii2lab\init\filters;

use yii\helpers\ArrayHelper;
use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;
use yii2lab\init\base\PlaceholderBaseFilter;

class ConfigureDb extends PlaceholderBaseFilter {

	public $placeholderMask = '{name}_DB';
	public $argName = 'db';

	public function run()
	{
		$this->loadDefault('db');
		$config = $this->userInput();
		Output::line();
		Output::arr($config);
		$this->saveData($config);
	}

	private function saveData($config) {
		$replacement = $this->generateReplacement($config);
		$this->replaceContentList($replacement);
	}

	protected function inputData() {
		$config = [];
		$answer = Question::confirm('DB configure?');
		if($answer) {
			Output::line();
			$config = $this->default;
			$config['driver'] = $this->showSelect('driver');
			$config['host'] = $this->showInput('host');
			$config['username'] = $this->showInput('username');
			$config['password'] = $this->showInput('password');
			$config['dbname'] = $this->showInput('dbname');
			if($config['driver'] == 'pgsql') {
				$config['defaultSchema'] = $this->showInput('defaultSchema');
			}
		}
		$config = $this->setDefault($config);
		return $config;
	}

}
