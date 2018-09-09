<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\app\admin\forms\ModeForm;
use yii2lab\extension\console\helpers\input\Enter;
use yii2lab\extension\console\helpers\Output;
use yii2lab\extension\yii\helpers\ArrayHelper;
use yii2lab\app\domain\enums\YiiEnvEnum;

class Mode extends BaseFilter {

	public $argName = 'env';
	
	public function run() {
		$config = $this->getData();
		$inputData = $this->userInput();
		$inputData = ArrayHelper::merge($this->default, $inputData);
		Output::line();
		Output::arr($inputData);
		$config['mode'] = $inputData;
		$this->setData($config);
	}
	
	protected function inputData() {
		$config = Enter::form(ModeForm::class, $this->default, ModeForm::SCENARIO_ENV);
		$config['debug'] = $config['env'] != YiiEnvEnum::PROD;
		$config['debug'] = !empty($config['debug']);
		return $config;
	}

}
