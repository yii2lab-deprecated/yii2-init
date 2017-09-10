<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;

class SetMainDomain extends Base {

	public function run()
	{
		$this->loadDefault('domain');
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$this->replaceContentList([
			'_BASE_DOMAIN_PLACEHOLDER_' => $config['domain'],
			'_FRONTEND_DOMAIN_PLACEHOLDER_' => $config['frontend'],
			'_BACKEND_DOMAIN_PLACEHOLDER_' => $config['backend'],
			'_API_DOMAIN_PLACEHOLDER_' => $config['api'],
			'_STATIC_DOMAIN_PLACEHOLDER_' => $config['static'],
		]);
	}

	private function userInput() {
		$config = $this->default;
		$config['base'] = Enter::display('Base domain ' . $this->renderDefault('base'));
		$config = $this->setDefault($config);
		$this->assignDefault($config['base']);
		$config['api'] = Enter::display('API domain ' . $this->renderDefault('api'));
		$config['backend'] = Enter::display('Backend domain ' . $this->renderDefault('backend'));
		$config['static'] = Enter::display('Static domain ' . $this->renderDefault('static'));
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
