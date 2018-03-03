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
        $projectEntity = self::userInput();
        Output::line();
        self::initializationConfirm($projectEntity);
		return $projectEntity;
	}

	private static function userInput()
	{
		$envParam = ArgHelper::one('project');
        $projects = Project::all();
        $projectTitles = Project::allTitles();
		if(count($projects) < 1) {
			throw new InvalidConfigException('Not configured project list');
		}
		if(count($projects) == 1) {
            return Project::first();
		}
        if(!empty($envParam)) {
            return Project::oneByName($envParam);
        }
        $answer = Select::display('Which environment do you want the application to be initialized in?', $projectTitles, 0);
        $answerString = ArrayHelper::first($answer);
        return Project::oneByTitle($answerString);
	}
	
	private static function initializationConfirm($projectEntity)
	{
		$envParam = ArgHelper::one('project');
		if (!is_string($envParam)) {
			Question::confirm("Initialize the application under '{$projectEntity['title']}' environment?", 1);
			Output::line();
		}
	}

}
