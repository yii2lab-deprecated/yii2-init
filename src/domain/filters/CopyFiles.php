<?php

namespace yii2lab\init\domain\filters;

use yii2lab\designPattern\command\interfaces\CommandInterface;

class CopyFiles implements CommandInterface {

	public $paths = [];
	
	public function run()
	{
		$copyFiles = new \yii2lab\console\helpers\CopyFiles;
		foreach($this->paths as $directory) {
			$copyFiles->copyAllFiles($directory);
		}
	}

}
