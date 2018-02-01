<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\app\admin\forms\ConnectionForm;
use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\filter\interfaces\FilterInterface;
use yii2lab\helpers\yii\ArrayHelper;

class ServerDb extends BaseFilter implements FilterInterface {

	public $argName = 'db';

	public function run($config)
	{
		$inputData = $this->userInput();
		$inputData = ArrayHelper::merge($this->default, $inputData);
		Output::line();
		Output::arr($inputData);
		$config['servers']['db']['main'] = $inputData;
		$config['servers']['db']['test'] = [
			'driver' => 'mysql',
			'host' => 'localhost',
			'username' => 'root',
			'password' => '',
			'dbname' => $inputData['dbname'] . '_test',
		];
		return $config;
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