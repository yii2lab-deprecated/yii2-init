<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;

class Init {

	function run()
	{
		Output::line();
		Output::line("Yii Application Initialization Tool v1.0");
		
		CheckRequirements::run();
		$projectConfig = $this->getProjectConfig();
		
		Output::pipe("Start initialization");
		Output::line();

		$this->copyFiles($projectConfig);
		Filter::all($projectConfig);

		Output::line();
		Output::pipe("initialization completed!");
	}
	
	private function getProjectConfig()
	{
		$projectName = SelectProject::run();
		$projectConfig = Config::one('project.' . $projectName);
		if(empty($projectConfig)) {
			Error::line("No config for {$projectName} project!");
			die;
		}
		return $projectConfig;
	}
	
	private function copyFiles($projectConfig)
	{
		$copyFiles = new CopyFiles;
		$copyFiles->run($projectConfig);
	}

}
