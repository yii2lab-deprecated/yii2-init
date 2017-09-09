<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;

class SetDb extends Base {

	public $root;
	public $paths;
	public $appList;

	public function run()
	{
		$answer = Question::display('Select DB driver', ['mysql', 'pgsql']);
		$value = $answer == 'm' ? 'mysql' : 'pgsql';
		$this->replaceContent($this->paths, $value, '_DRIVER_DB_PLACEHOLDER_');
		$answer = Enter::display('Enter DB user');
		$this->replaceContent($this->paths, $answer, '_USER_DB_PLACEHOLDER_');
		$answer = Enter::display('Enter DB password');
		$this->replaceContent($this->paths, $answer, '_PASSWORD_DB_PLACEHOLDER_');
	}

}
