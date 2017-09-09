<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;

class SetMainDomain extends Base {

	public $root;
	public $paths;
	public $appList;

	public function run()
	{
		$answer = Enter::display('Enter site domain');
		$this->replaceContent($this->paths, $answer, '_MAIN_DOMAIN_PLACEHOLDER_');
	}

}
