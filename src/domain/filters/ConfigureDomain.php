<?php

namespace yii2lab\init\domain\filters;

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
		$config = $this->default;
		$config['base'] = $this->showInput('base', null, null, true);
		$config = $this->setDefault($config);
		$config['api'] = $this->showInput('api');
		$config['backend'] = $this->showInput('backend');
		$config['static'] = $this->showInput('static');
		$config['tps'] = $this->showInput('tps');
		$config['core'] = $this->showInput('core');
		//$config = $this->setDefault($config);
		return $config;
	}

	private function assignDefault($config) {
		$base = $config['base'];
		$config['frontend'] = !empty($config['frontend']) ? $config['frontend'] : $base;
		$config['backend'] = !empty($config['backend']) ? $config['backend'] : 'admin.' . $base;
		$config['api'] = !empty($config['api']) ? $config['api'] : 'api.' . $base;
		$config['static'] = !empty($config['static']) ? $config['static'] : $base;
		return $config;
	}

	protected function setDefault($config) {
		$config = parent::setDefault($config);
		$config = $this->assignDefault($config);
		return $config;
	}

}
