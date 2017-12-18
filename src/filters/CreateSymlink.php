<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;
use yii2lab\init\base\FileBaseFilter;
use yii2lab\misc\interfaces\CommandInterface;

class CreateSymlink extends FileBaseFilter implements CommandInterface {

	public function run()
	{
		foreach ($this->paths as $link => $target) {
			//first removing folders to avoid errors if the folder already exists
			$this->removeDir($link);
			//next removing existing symlink in order to update the target
			$this->removeSymlinkFile($link);
			$isCreated = $this->createSymlinkFile($target, $link);
			$message = $this->getFileName($target) . " " . $this->getFileName($link);
			if ($isCreated) {
				Output::line("      symlink " . $message);
			} else {
				Error::line("Cannot create symlink " . $message);
			}
		}
	}

	protected function createSymlinkFile($target, $link)
	{
		return @symlink($this->getFileName($target), $this->getFileName($link));
	}

	protected function isSymlinkFile($name)
	{
		$file = $this->getFileName($name);
		return is_link($file);
	}

	protected function removeSymlinkFile($name)
	{
		if ($this->isSymlinkFile($name)) {
			$this->removeFile($name);
		}
	}

}
