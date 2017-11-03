<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Output;
use yii2lab\init\base\PlaceholderBaseFilter;

class ConfigureDomain extends PlaceholderBaseFilter {

	public $placeholderMask = '{name}_DOMAIN';

	public function run()
	{
		$this->loadDefault('domain');
		$config = $this->userInput();
		Output::line();
		Output::arr($config);
		$this->saveData($config);
	}

	private function saveData($config) {
		$replacement = $this->generateReplacement($config);
		$this->replaceContentList($replacement);
	}

	private function userInput() {
		$config = $this->default;
		$config['base'] = $this->showInput('base', null, null, true);
		$config = $this->setDefault($config);
		$this->assignDefault($config['base']);
		$config['api'] = $this->showInput('api');
		$config['backend'] = $this->showInput('backend');
		$config['static'] = $this->showInput('static');
		$config['tps'] = $this->showInput('tps');
		$config['core'] = $this->showInput('core');
		$config = $this->setDefault($config);
		return $config;
	}

	private function assignDefault($base) {
		$this->default['frontend'] = $base;
		$this->default['backend'] = 'admin.' . $base;
		$this->default['api'] = 'api.' . $base;
		$this->default['static'] = $base;
	}

}
