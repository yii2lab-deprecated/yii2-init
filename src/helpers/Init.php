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

	function run()
	{
		Output::line();
		$this->checkRequirements();

		Output::line("Yii Application Initialization Tool v1.0");

		$envName = $this->inputProject();

		$this->initializationConfirm($envName);

		Output::pipe("Start initialization");

		$env = $this->getConfigItem('project.' . $envName);

		$this->copyFiles($env);
		$this->runCallbacks($env);

		Output::pipe("initialization completed!");
	}

	private function getConfigItem($name = null)
	{
		return ArrayHelper::getValue($this->config, $name);
	}

	private function copyFiles($env)
	{
		$copyFiles = new CopyFiles;
		$copyFiles->root = $this->getRoot();
		$copyFiles->env = $env;
		$copyFiles->run();
	}

	private function runCallbacks($env)
	{
		$callbacks = new Callbacks;
		$callbacks->root = $this->getRoot();
		$callbacks->env = $env;
		$callbacks->appList = $this->appList;
		$callbacks->run();
	}

	private function getRoot()
	{
		return str_replace('\\', '/', $this->dir);
	}

	private function checkRequirements()
	{
		if (!extension_loaded('openssl')) {
			Output::line('The OpenSSL PHP extension is required by Yii2.');
			die();
		}
	}

	private function inputProject()
	{
		$envParam = Env::getOneParam('env');
		$envName = null;
		$envNames = array_keys($this->getConfigItem('project'));
		if (empty($envParam) || $envParam === '1') {
			$answer = Select::display('Which environment do you want the application to be initialized in?', $envNames, 0);
			$envName = ArrayHelper::first($answer);
		} else {
			$envName = $envParam;
		}
		return $envName;
	}

	private function initializationConfirm($envName)
	{
		$envParam = Env::getOneParam('env');
		if (empty($envParam)) {
			Question::confirm("Initialize the application under '{$envName}' environment?", 1);
			Output::line();
		}
	}

}
