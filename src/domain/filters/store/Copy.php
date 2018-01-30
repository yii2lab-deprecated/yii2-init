<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\designPattern\filter\interfaces\FilterInterface;

class Copy implements FilterInterface {
	
	public $paths = [];
	
	public function run($config)
	{
		$copyFiles = new \yii2lab\console\helpers\CopyFiles;
		foreach($this->paths as $directory) {
			$copyFiles->copyAllFiles($directory);
		}
		return $config;
	}

}
