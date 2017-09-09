<?php

namespace yii2lab\init\helpers;

use yii\helpers\FileHelper;
use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;

class CopyFiles {

	public $root;
	public $env;

	private $isCopyAll = false;
	
	public function run()
	{
		$this->copyAllFiles("environments/{$this->env['path']}");
		$this->copyAllFiles("environments/common");
	}

	private function copyAllFiles($path)
	{
		$files = $this->getFileList("{$this->root}/$path");
		$files = $this->skipFiles($files);
		$this->isCopyAll = false;
		foreach ($files as $file) {
			if (!$this->copyFile("$path/$file", $file)) {
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

	private function skipFiles($files)
	{
		if (isset($this->env['skipFiles'])) {
			$files = array_diff($files, $this->env['skipFiles']);
		}
		return $files;
	}
	
	private function copyFile($source, $target)
	{
		$sourceFile = $this->root . '/' . $source;
		$targetFile = $this->root . '/' . $target;

		if (!is_file($sourceFile)) {
			Output::line("       skip $target ($source not exist)");
			return true;
		}
		if (is_file($targetFile)) {
			if (file_get_contents($sourceFile) === file_get_contents($targetFile)) {
				Output::line("  unchanged $target");
				return true;
			}
			if ($this->isCopyAll) {
				Output::line("  overwrite $target");
			} else {
				Output::line("      exist $target");
				$answer = $this->inputOverwrite();
				if ($answer == 'q') {
					return false;
				}
				if ($answer == 'y') {
					Output::line("  overwrite $target");
				} else {
					if ($answer == 'a') {
						Output::line("  overwrite $target");
						$this->isCopyAll = true;
					} else {
						Output::line("       skip $target");
						return true;
					}
				}
			}
			$this->doCopyFile($sourceFile, $targetFile);
			return true;
		}
		Output::line("   generate $target");
		$this->doCopyFile($sourceFile, $targetFile);
		return true;
	}

	private function doCopyFile($sourceFile, $targetFile) {
		$targetDir = dirname($targetFile);
		if(!is_dir($targetDir)) {
			FileHelper::createDirectory($targetDir, 0777);
		}
		$sourceData = file_get_contents($sourceFile);
		file_put_contents($targetFile, $sourceData);
	}

	private function inputOverwrite() {
		$answer = Question::display('            ...overwrite?', [
			'y' => 'Yes',
			'n' => 'No',
			'a' => 'All',
			'q' => 'Quit',
		], 'n');
		return $answer;
	}
	
}
