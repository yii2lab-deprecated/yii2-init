<?php

namespace yii2lab\init\domain\filters;

use yii2lab\designPattern\command\interfaces\CommandInterface;

class CopyFiles implements CommandInterface {

	public $directories = [];
	
	public function run()
	{
		$copyFiles = new \yii2lab\init\domain\helpers\CopyFiles;
		foreach($this->directories as $directory) {
			$copyFiles->run($directory);
		}
	}

}
