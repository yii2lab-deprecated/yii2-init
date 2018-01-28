<?php

namespace yii2lab\init\domain\filters;

use yii2lab\app\admin\forms\UrlForm;
use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\Output;
use yii2lab\init\domain\base\PlaceholderBaseFilter;
use yii2lab\designPattern\command\interfaces\CommandInterface;

class ConfigureDomain extends PlaceholderBaseFilter implements CommandInterface {

	public $placeholderMask = '{name}_DOMAIN';
	public $argName = 'domain';

	public function run()
	{
		$config = $this->userInput();
		Output::line();
		Output::arr($config);
		$this->saveData($config);
	}

	protected function inputData() {
		$config = Enter::form(UrlForm::className(), $this->default);
		return $config;
	}

}
