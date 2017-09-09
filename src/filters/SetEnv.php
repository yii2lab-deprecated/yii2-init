<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Question;

class SetEnv extends Base {

	public $root;
	public $paths;
	public $appList;

	public function run()
	{
		$answer = Question::display('Select env', ['prod', 'dev']);
		$value = $answer == 'p' ? 'prod' : 'dev';
		$this->replaceContent($value, '_YII_ENV_PLACEHOLDER_');
		$value = $answer == 'p' ? 'false' : 'true';
		$this->replaceContent($value, '_YII_DEBUG_PLACEHOLDER_');
	}

}
