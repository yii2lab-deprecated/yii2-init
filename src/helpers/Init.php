<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\input\Select;
use yii2lab\console\helpers\Output;
use yii2mod\helpers\ArrayHelper;

class Init {

	public $dir;
	public $config;
	public $appList;

	private $params;
	private $root;

	function run()
	{
		Output::line();
		if (!extension_loaded('openssl')) {
			Output::line('The OpenSSL PHP extension is required by Yii2.');
			die();
		}

		$this->params = $this->getParams();
		$this->root = str_replace('\\', '/', $this->dir);

		Output::line("Yii Application Initialization Tool v1.0");

		$envName = $this->getEnvName();

		$this->initializationConfirm($envName);

		Output::pipe("Start initialization");

		$env = $this->config[$envName];

		$copyFiles = new CopyFiles;
		$copyFiles->root = $this->root;
		$copyFiles->env = $env;
		$copyFiles->run();

		$callbacks = new Callbacks;
		$callbacks->root = $this->root;
		$callbacks->env = $env;
		$callbacks->appList = $this->appList;
		$callbacks->run();

		Output::pipe("initialization completed!");
	}

	private function getEnvName()
	{
		$envName = null;
		$envNames = array_keys($this->config);
		if (empty($this->params['env']) || $this->params['env'] === '1') {
			$answer = Select::display('Which environment do you want the application to be initialized in?', $envNames, 0);
			$envName = ArrayHelper::first($answer);
		} else {
			$envName = $this->params['env'];
		}
		return $envName;
	}

	private function initializationConfirm($envName)
	{
		if (empty($this->params['env'])) {
			Question::confirm("Initialize the application under '{$envName}' environment?", 1);
			Output::line();
		}
	}
	
	private function getParams()
	{
		$rawParams = [];
		if (isset($_SERVER['argv'])) {
			$rawParams = $_SERVER['argv'];
			array_shift($rawParams);
		}
		$params = [];
		foreach ($rawParams as $param) {
			if (preg_match('/^--(\w+)(=(.*))?$/', $param, $matches)) {
				$name = $matches[1];
				$params[$name] = isset($matches[3]) ? $matches[3] : true;
			} else {
				$params[] = $param;
			}
		}
		return $params;
	}

}
