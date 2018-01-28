<?php

namespace yii2lab\init\domain\filters;

use yii2lab\app\admin\forms\ConnectionForm;
use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;
use yii2lab\init\domain\base\PlaceholderBaseFilter;
use yii2lab\designPattern\command\interfaces\CommandInterface;

class ConfigureDb extends PlaceholderBaseFilter implements CommandInterface {

	public $placeholderMask = '{name}_DB';
	public $argName = 'db';

	public function run()
	{
		$config = $this->userInput();
		Output::line();
		Output::arr($config);
		$this->saveData($config);
	}

	protected function inputData() {
		$config = $this->default;
		$answer = Question::confirm('DB configure?');
		if($answer) {
			Output::line();
			$config = Enter::form(ConnectionForm::className(), $this->default);
		}
		$config = $this->setDefault($config);
		return $config;
	}

}
