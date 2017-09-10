<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;

class SetMainDomain extends Base {

	public $root;
	public $paths;
	public $appList;
	public $default = [
		'base' => 'wooppay.yii',
	];

	public function run()
	{
		$config = $this->userInput();
		$this->saveData($config);
	}

	private function saveData($config) {
		$this->replaceContentList([
			'_BASE_DOMAIN_PLACEHOLDER_' => $config['domain'],
			'_FRONTEND_DOMAIN_PLACEHOLDER_' => $config['frontend'],
			'_BACKEND_DOMAIN_PLACEHOLDER_' => $config['backend'],
			'_API_DOMAIN_PLACEHOLDER_' => $config['api'],
		]);
	}

	private function userInput() {
		$config['base'] = Enter::display('Base domain ' . $this->renderDefault('base'));
		$this->assignDefault($config['base']);
		$config['api'] = Enter::display('API domain ' . $this->renderDefault('api'));
		$config['backend'] = Enter::display('Backend domain ' . $this->renderDefault('backend'));
		$config = $this->setDefault($config);
		return $config;
	}

	private function assignDefault($base) {
		$this->default['frontend'] = $base;
		$this->default['backend'] = 'admin.' . $base;
		$this->default['api'] = 'api.' . $base;
	}

}
