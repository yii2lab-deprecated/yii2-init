<?php

namespace yii2lab\init\domain\helpers;

use yii2lab\extension\console\helpers\Arg;
use yii2lab\extension\console\helpers\Error;
use yii2lab\extension\console\helpers\Output;

class Init {

	protected static $aliases = [
		'r' => 'requirements',
	];
	
	public static function run()
	{
		$argManager = new Arg(self::$aliases);
		if($argManager->hasOption('requirements')) {
			CheckYiiRequirements::run()->render();
		} else {
			self::runInit();
		}
	}
	
	private static function runInit()
	{
		Output::title("Application Initialization Tool");
		
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
        $projectEntity = SelectProject::run();
		if(empty($projectEntity)) {
			Error::line("No config for {$projectEntity['name']} project!");
			die;
		}
		return $projectEntity;
	}
	
}
