<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\extension\console\helpers\Error;
use yii2lab\extension\console\helpers\Output;
use yii2lab\extension\scenario\base\BaseScenario;
use yii2lab\init\domain\helpers\FileSystemHelper;

class CreateSymlink extends BaseScenario {
	
	public $paths = [];
	
	public function run() {
		foreach ($this->paths as $link => $target) {
			//first removing folders to avoid errors if the folder already exists
			FileSystemHelper::removeDir($link);
			//next removing existing symlink in order to update the target
			$this->removeSymlinkFile($link);
			$isCreated = $this->createSymlinkFile($target, $link);
			$message = FileSystemHelper::getFileName($target) . " " . FileSystemHelper::getFileName($link);
			if ($isCreated) {
				Output::line("      symlink " . $message);
			} else {
				Error::line("Cannot create symlink " . $message);
			}
		}
	}
	
	protected function createSymlinkFile($target, $link)
	{
		return @symlink(FileSystemHelper::getFileName($target), FileSystemHelper::getFileName($link));
	}
	
	protected function removeSymlinkFile($name)
	{
		if (FileSystemHelper::isSymlinkFile($name)) {
			FileSystemHelper::removeFile($name);
		}
	}

}
