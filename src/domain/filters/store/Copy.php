<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\designPattern\scenario\base\BaseScenario;

class Copy extends BaseScenario {
	
	public $paths = [];
	
	public function run() {
		$config = $this->getData();
		$copyFiles = new \yii2lab\console\helpers\CopyFiles;
		foreach($this->paths as $directory) {
			$copyFiles->copyAllFiles($directory);
		}
		$this->setData($config);
	}
	
}
