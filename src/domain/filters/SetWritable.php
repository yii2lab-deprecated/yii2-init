<?php

namespace yii2lab\init\domain\filters;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;
use yii2lab\init\domain\base\BaseFilter;
use yii2lab\init\domain\helpers\Config;
use yii2lab\designPattern\command\interfaces\CommandInterface;
use yii2lab\init\domain\helpers\FileSystemHelper;

class SetWritable extends BaseFilter implements CommandInterface {

	public function run()
	{
		$paths = $this->getWritableDirs($this->paths);
		foreach ($paths as $writable) {
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

	private function getWritableDirs($paths = [])
	{
		$root = ROOT_DIR;
		$rootDirs = scandir($root);
		$appList = [];
		$exclude = ['vendor', 'environments'];
		foreach($rootDirs as $dir) {
			if($dir[0] != '.' && FileSystemHelper::isDir($dir) && !in_array($dir, $exclude)) {
				$appList[] = $dir;
			}
		}
		foreach($appList as $app) {
			if(FileSystemHelper::isDir("$app/runtime")) {
				$paths[] = "$app/runtime";
			}
			if(FileSystemHelper::isDir("$app/web/assets")) {
				$paths[] = "$app/web/assets";
			}
		}
		$paths = array_unique($paths);
		return $paths;
	}

}
