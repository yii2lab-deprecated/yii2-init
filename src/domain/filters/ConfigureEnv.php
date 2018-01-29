<?php

namespace yii2lab\init\domain\filters;

use yii2lab\app\admin\forms\ModeForm;
use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\Output;
use yii2lab\init\domain\base\PlaceholderBaseFilter;
use yii2lab\designPattern\command\interfaces\CommandInterface;

class ConfigureEnv extends PlaceholderBaseFilter implements CommandInterface {

	public $placeholderMask = 'YII_ENV_{name}';
	public $argName = 'env';

	public function run()
	{
		$config = $this->userInput();
		Output::line();
		Output::arr($config);
		$this->placeholder->saveData($config);
	}

	protected function inputData() {
		$config = Enter::form(ModeForm::className(), $this->default);
		$config['debug'] = !empty($config['debug']);
		return $config;
	}

}
