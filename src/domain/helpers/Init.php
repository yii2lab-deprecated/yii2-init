<?php

namespace yii2lab\init\domain\helpers;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;
use yii2lab\init\domain\helpers\CheckYiiRequirements;

class Init {

	public static function run(array $argv = [])
	{
		$isRequirements = in_array('--requirements', $argv);
		if($isRequirements) {
			CheckYiiRequirements::run()->render();
		} else {
			self::runInit();
		}
	}
	
	private static function runInit()
	{
		Output::line();
		Output::line("Yii Application Initialization Tool v1.0");
		
		CheckRequirements::run();
		$projectConfig = self::getProjectConfig();
		
		Output::pipe("Start initialization");
		Output::line();
		
		$envConfig = Filter::allInput($projectConfig['filters']);
		
		Output::line();
		Output::pipe("initialization completed!");
	}
	
	private static function getProjectConfig()
	{
		$projectName = SelectProject::run();
		$projectConfig = Config::one('project.' . $projectName);
		if(empty($projectConfig)) {
			Error::line("No config for {$projectName} project!");
			die;
		}
		return $projectConfig;
	}
	
}
