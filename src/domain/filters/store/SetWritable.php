<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\extension\console\helpers\Error;
use yii2lab\extension\console\helpers\Output;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\init\domain\helpers\FileSystemHelper;

class SetWritable extends BaseScenario {
	
	public $target = [
		'frontend',
		'backend',
		'api',
		'console',
		//'common',
	];
	public $paths = [
		'frontend/web/images',
		'common/runtime',
		'{app}/runtime',
		'{app}/web/assets',
	];
	public $ignorePaths = [
		'console/web/assets',
	];
	
	public function run() {
		$paths = $this->getWritableDirs();
		foreach ($paths as $writable) {
			if(in_array($writable, $this->ignorePaths)) {
				Output::line("ignored $writable");
				continue;
			}
			if (FileSystemHelper::isDir($writable)) {
				if (FileSystemHelper::chmodFile($writable, 0777)) {
					Output::line("chmod 0777 $writable");
				} else {
					Error::line("Operation chmod not permitted for directory $writable.");
				}
			} else {
				Error::line("Directory $writable does not exist.");
			}
		}
	}
	
	private function getWritableDirs()
	{
		$result = [];
		foreach($this->target as $app) {
			foreach($this->paths as $path) {
				if(preg_match('#\{[^}]+\}#i', $path)) {
					$result[] = str_replace(['{app}'], [$app], $path);
				} else {
					$result[] = $path;
				}
			}
		}
		$result = array_unique($result);
		return $result;
	}

}
