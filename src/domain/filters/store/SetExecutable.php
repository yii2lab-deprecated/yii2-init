<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\scenario\base\BaseScenario;
use yii2lab\init\domain\helpers\FileSystemHelper;

class SetExecutable extends BaseScenario {
	
	public $paths = [];
	
	public function run() {
		$config = $this->getData();
		foreach ($this->paths as $executable) {
			if (FileSystemHelper::isFile($executable)) {
				if (FileSystemHelper::chmodFile($executable, 0755)) {
					Output::line("chmod 0755 $executable");
				} else {
					Error::line("Operation chmod not permitted for $executable.");
				}
			} else {
				Error::line("$executable does not exist.");
			}
		}
		$this->setData($config);
	}
	
}
