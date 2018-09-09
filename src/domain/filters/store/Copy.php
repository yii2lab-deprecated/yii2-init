<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\extension\scenario\base\BaseScenario;

class Copy extends BaseScenario {
	
	public $paths = [];
	
	public function run() {
		$copyFiles = new \yii2lab\extension\console\helpers\CopyFiles;
		foreach($this->paths as $directory) {
			$copyFiles->copyAllFiles($directory);
		}
	}
	
}
