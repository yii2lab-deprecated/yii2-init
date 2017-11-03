<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;
use yii2lab\helpers\yii\FileHelper;

class CopyFiles {
	
	private $projectConfig;
	private $isCopyAll = false;
	
	public function run($projectConfig)
	{
		$this->projectConfig = $projectConfig;
		$this->copyAllFiles("environments/{$this->projectConfig['path']}");
		$this->copyAllFiles("environments/common");
	}

	private function copyAllFiles($path)
	{
		$files = $this->getFileList(Config::root() . "/$path");
		$files = $this->filterSkipFiles($files);
		//$this->isCopyAll = false;
		foreach ($files as $file) {
			$source = "$path/$file";
			if (!$this->copyFile($source, $file)) {
				break;
			}
		}
	}
	
	private function getFileList($root, $basePath = '')
	{
		$files = [];
		$handle = opendir($root);
		while (($path = readdir($handle)) !== false) {
			if ($path === '.git' || $path === '.svn' || $path === '.' || $path === '..') {
				continue;
			}
			$fullPath = "$root/$path";
			$relativePath = $basePath === '' ? $path : "$basePath/$path";
			if (is_dir($fullPath)) {
				$files = array_merge($files, $this->getFileList($fullPath, $relativePath));
			} else {
				$files[] = $relativePath;
			}
		}
		closedir($handle);
		return $files;
	}

	private function filterSkipFiles($files)
	{
		if (isset($this->projectConfig['skipFiles'])) {
			$files = array_diff($files, $this->projectConfig['skipFiles']);
		}
		return $files;
	}
	
	private function copyFile($source, $target)
	{
		$sourceFile = Config::root() . '/' . $source;
		$targetFile = Config::root() . '/' . $target;
		if (!is_file($sourceFile)) {
			Output::line("     skip $target ($source not exist)");
			return true;
		}
		if (is_file($targetFile)) {
			if (FileHelper::isEqualContent($sourceFile, $targetFile)) {
				Output::line("unchanged $target");
				return true;
			}
			if($this->runOverwriteDialog($target)) {
				return true;
			}
			FileHelper::copy($sourceFile, $targetFile, 0777);
			return true;
		}
		Output::line("generate $target");
		FileHelper::copy($sourceFile, $targetFile, 0777);
		return true;
	}

	private function runOverwriteDialog($target) {
		if ($this->isCopyAll) {
			Output::line("overwrite $target");
		} else {
			Output::line("exist $target");
			$answer = $this->inputOverwrite();
			if ($answer == 'y') {
				Output::line("overwrite $target");
			} else {
				if ($answer == 'a') {
					Output::line("overwrite $target");
					$this->isCopyAll = true;
				} else {
					Output::line("skip $target");
					return true;
				}
			}
		}
		return false;
	}

	private function inputOverwrite() {
		$answer = Question::display('    ...overwrite?', [
			'y' => 'Yes',
			'n' => 'No',
			'a' => 'All',
			'q' => 'Quit',
		], 'n');
		if($answer == 'q') {
			Output::quit();
		}
		return $answer;
	}
	
}
