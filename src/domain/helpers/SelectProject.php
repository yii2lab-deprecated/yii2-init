<?php

namespace yii2lab\init\domain\helpers;

use yii\base\InvalidConfigException;
use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\input\Select;
use yii2lab\console\helpers\Output;
use yii2lab\console\helpers\ArgHelper;
use yii2mod\helpers\ArrayHelper;

class SelectProject {

	public static function run()
	{
		$projectName = self::userInput();
		return $projectName;
	}

	private static function userInput()
	{
		$envParam = ArgHelper::one('project');
		$projectName = null;
		$projectNames = array_keys(Config::one('project'));
		
		if(count($projectNames) < 1) {
			throw new InvalidConfigException('Not configured project list');
		}
		if(count($projectNames) == 1) {
			$projectName = $projectNames[0];
		} else {
			if (!is_string($envParam)) {
				$answer = Select::display('Which environment do you want the application to be initialized in?', $projectNames, 0);
				$projectName = ArrayHelper::first($answer);
			} else {
				$projectName = $projectNames[$envParam];
			}
		}
		
		Output::line();
		self::initializationConfirm($projectName);
		return $projectName;
	}
	
	private static function initializationConfirm($projectName)
	{
		$envParam = ArgHelper::one('project');
		if (!is_string($envParam)) {
			Question::confirm("Initialize the application under '{$projectName}' environment?", 1);
			Output::line();
		}
	}

}
