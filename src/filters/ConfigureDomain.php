<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Output;

class ConfigureDomain extends Base {

	public $placeholderMask = '{name}_DOMAIN';

	public function run()
	{
		$this->loadDefault('domain');
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$replacement = $this->generateReplacement($config);
		$this->replaceContentList($replacement);
	}

	private function userInput() {
		$config = $this->default;
		$config['base'] = $this->showInput('base', null, 'Base domain', true);
		$config = $this->setDefault($config);
		$this->assignDefault($config['base']);

		$config['api'] = $this->showInput('api', null, 'API domain');
		$config['backend'] = $this->showInput('backend', null, 'Backend domain');
		$config['static'] = $this->showInput('static', null, 'Static domain');
		$config['tps'] = $this->showInput('tps', null, 'TPS domain');
		$config['core'] = $this->showInput('core', null, 'Core domain');

		$config = $this->setDefault($config);

		Output::line();
		Output::arr($config);

		return $config;
	}

	private function assignDefault($base) {
		$this->default['frontend'] = $base;
		$this->default['backend'] = 'admin.' . $base;
		$this->default['api'] = 'api.' . $base;
		$this->default['static'] = $base;
	}

}
