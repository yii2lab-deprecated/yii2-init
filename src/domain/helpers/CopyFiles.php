<?php

namespace yii2lab\init\domain\helpers;

class CopyFiles extends \yii2lab\console\helpers\CopyFiles {
	
	protected $ignoreNames = [
		'.git',
		'.svn',
		'.',
		'..',
	];
	
	public function run($directory)
	{
		$this->copyAllFiles($directory);
	}
	
}
