<?php

namespace yii2lab\init\domain\filters;

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
		$this->saveData($config);
	}

	protected function inputData() {
		$config['env'] = $this->showSelect('env', null, 'Select env');
		$config = $this->setDefault($config);
		$config['debug'] = $config['env'] == 'prod' ? 'false' : 'true';
		return $config;
	}

}
