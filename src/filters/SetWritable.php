<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;
use yii2lab\init\base\FileBaseFilter;
use yii2lab\init\helpers\Config;
use yii2lab\misc\interfaces\CommandInterface;

class setWritable extends FileBaseFilter implements CommandInterface {

	public function run()
	{
		$paths = $this->getWritableDirs($this->paths);
		foreach ($paths as $writable) {
			if ($this->isDir($writable)) {
				if ($this->chmodFile($writable, 0777)) {
					Output::line("chmod 0777 $writable");
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
		$root = Config::root();
		$rootDirs = scandir($root);
		$appList = [];
		$exclude = ['vendor', 'environments'];
		foreach($rootDirs as $dir) {
			if($dir[0] != '.' && $this->isDir($dir) && !in_array($dir, $exclude)) {
				$appList[] = $dir;
			}
		}
		foreach($appList as $app) {
			if($this->isDir("$app/runtime")) {
				$paths[] = "$app/runtime";
			}
			if($this->isDir("$app/web/assets")) {
				$paths[] = "$app/web/assets";
			}
		}
		$paths = array_unique($paths);
		return $paths;
	}

}
