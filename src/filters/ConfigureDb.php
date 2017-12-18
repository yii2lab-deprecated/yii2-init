<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;
use yii2lab\init\base\PlaceholderBaseFilter;
use yii2lab\misc\interfaces\CommandInterface;

class ConfigureDb extends PlaceholderBaseFilter implements CommandInterface {

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
