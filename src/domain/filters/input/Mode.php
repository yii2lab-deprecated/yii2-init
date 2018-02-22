<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\app\admin\forms\ModeForm;
use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\filter\interfaces\FilterInterface;
use yii2lab\helpers\yii\ArrayHelper;

class Mode extends BaseFilter implements FilterInterface {

	public $argName = 'env';

	public function run($config)
	{
		$inputData = $this->userInput();
		$inputData = ArrayHelper::merge($this->default, $inputData);
		Output::line();
		Output::arr($inputData);
		$config['mode'] = $inputData;
		return $config;
	}
	
	protected function inputData() {
		$config = Enter::form(ModeForm::class, $this->default);
		$config['debug'] = !empty($config['debug']);
		return $config;
	}

}
