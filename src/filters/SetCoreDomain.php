<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;

class SetCoreDomain extends Base {

	public $root;
	public $paths;
	public $appList;

	public function run()
	{
		$answer = Enter::display('Enter core api domain');
		$this->replaceContent($answer, '_CORE_DOMAIN_PLACEHOLDER_');
	}

}
