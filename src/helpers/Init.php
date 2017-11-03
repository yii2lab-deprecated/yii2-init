<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;

class Init {

	function run()
	{
		Output::line();
		
		Filter::one('checkRequirements');

		Output::line("Yii Application Initialization Tool v1.0");

		$projectName = Filter::one('selectProject');

		Output::pipe("Start initialization");
		Output::line();

		$projectConfig = Config::one('project.' . $projectName);
		
		if(empty($projectConfig)) {
			Error::line("No config for {$projectName} project!");
		}

		$this->copyFiles($projectConfig);
		Filter::all($projectConfig);

		Output::line();
		Output::pipe("initialization completed!");
	}

	private function copyFiles($projectConfig)
	{
		$copyFiles = new CopyFiles;
		$copyFiles->projectConfig = $projectConfig;
		$copyFiles->run();
	}

}
