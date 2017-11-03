<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\input\Select;
use yii2lab\console\helpers\Output;
use yii2lab\console\helpers\ParameterHelper;
use yii2mod\helpers\ArrayHelper;

class Init {

	public $dir;
	
	function run()
	{
		Output::line();
		$this->checkRequirements();

		Output::line("Yii Application Initialization Tool v1.0");

		$projectName = $this->inputProject();
		Output::line();

		$this->initializationConfirm($projectName);

		Output::pipe("Start initialization");
		Output::line();

		$env = Config::one('project.' . $projectName);
		
		if(empty($env)) {
			Error::line("No config for {$projectName} project!");
		}

		$this->copyFiles($env);
		$this->runCallbacks($env);

		Output::line();
		Output::pipe("initialization completed!");
	}

	private function copyFiles($env)
	{
		$copyFiles = new CopyFiles;
		$copyFiles->env = $env;
		$copyFiles->run();
	}

	private function runCallbacks($env)
	{
		$callbacks = new Callbacks;
		$callbacks->env = $env;
		$callbacks->run();
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
		$envParam = ParameterHelper::one('project');
		$projectName = null;
		$projectNames = array_keys(Config::one('project'));
		if (!is_string($envParam)) {
			$answer = Select::display('Which environment do you want the application to be initialized in?', $projectNames, 0);
			$projectName = ArrayHelper::first($answer);
		} else {
			$projectName = $projectNames[$envParam];
		}
		return $projectName;
	}

	private function initializationConfirm($projectName)
	{
		$envParam = ParameterHelper::one('project');
		if (!is_string($envParam)) {
			Question::confirm("Initialize the application under '{$projectName}' environment?", 1);
			Output::line();
		}
	}

}
