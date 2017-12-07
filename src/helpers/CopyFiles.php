<?php

namespace yii2lab\init\helpers;

class CopyFiles extends \yii2lab\console\helpers\CopyFiles {
	
	protected $ignoreNames = [
		'.git',
		'.svn',
		'.',
		'..',
	];
	
	public function run($projectConfig)
	{
		$this->projectConfig = $projectConfig;
		$this->copyAllFiles("environments/{$this->projectConfig['path']}");
		$this->copyAllFiles("environments/common");
	}
	
}
