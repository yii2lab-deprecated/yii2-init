<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Error;

class setWritable extends Base {

	public function run()
	{
		$paths = $this->getWritableDirs($this->paths);
		foreach ($paths as $writable) {
			if (is_dir($this->root . "/$writable")) {
				if (@chmod($this->root . "/$writable", 0777)) {
					echo "      chmod 0777 $writable\n";
				} else {
					Error::line("Operation chmod not permitted for directory $writable.");
				}
			} else {
				Error::line("Directory $writable does not exist.");
			}
		}
	}

	private function getWritableDirs($paths = [])
	{
		$rootDirs = scandir($this->root);
		$appList = [];
		$exclude = ['vendor', 'common', 'environments'];
		foreach($rootDirs as $dir) {
			if($dir[0] != '.' && is_dir($this->root . "/$dir") && !in_array($dir, $exclude)) {
				$appList[] = $dir;
			}
		}
		foreach($appList as $app) {
			if(is_dir($this->root . "/$app/runtime")) {
				$paths[] = "$app/runtime";
			}
			if(is_dir($this->root . "/$app/web/assets")) {
				$paths[] = "$app/web/assets";
			}
		}
		$paths = array_unique($paths);
		return $paths;
	}

}
