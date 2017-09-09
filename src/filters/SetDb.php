<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;

class SetDb extends Base {

	public function run()
	{
		$answer = Question::display('Select DB driver', ['mysql', 'pgsql']);
		$value = $answer == 'm' ? 'mysql' : 'pgsql';
		$this->replaceContent($value, '_DRIVER_DB_PLACEHOLDER_');
		$answer = Enter::display('Enter DB user');
		$this->replaceContent($answer, '_USER_DB_PLACEHOLDER_');
		$answer = Enter::display('Enter DB password');
		$this->replaceContent($answer, '_PASSWORD_DB_PLACEHOLDER_');
	}

}
