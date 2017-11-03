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

		$projectConfig = Config::one('project.' . $projectName);
		
		if(empty($projectConfig)) {
			Error::line("No config for {$projectName} project!");
		}

		$this->copyFiles($projectConfig);
		$this->runCallbacks($projectConfig);

		Output::line();
		Output::pipe("initialization completed!");
	}

	private function copyFiles($projectConfig)
	{
		$copyFiles = new CopyFiles;
		$copyFiles->projectConfig = $projectConfig;
		$copyFiles->run();
	}

	private function runCallbacks($projectConfig)
	{
		$callbacks = new Callbacks;
		$callbacks->projectConfig = $projectConfig;
		$callbacks->run();
	}

}
