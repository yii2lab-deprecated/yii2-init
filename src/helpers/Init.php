<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;

class Init {

	public $dir;
	
	function run()
	{
		Output::line();
		
		Callbacks::runFilter('checkRequirements');

		Output::line("Yii Application Initialization Tool v1.0");

		$projectName = Callbacks::runFilter('selectProject');

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

}
