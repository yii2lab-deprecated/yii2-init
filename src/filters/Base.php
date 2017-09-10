<?php

namespace yii2lab\init\filters;

use yii2lab\helpers\yii\FileHelper;
use yii2lab\init\helpers\Init;

abstract class Base {

	public $root;
	/** @var Init */
	public $initInstance;
	public $paths;
	public $appList;
	public $default;

	abstract public function run();

	protected function loadDefault($name) {
		$default = $this->initInstance->getConfigItem('default.' . $name);
		if(!empty($default)) {
			$this->default = $default;
		}
	}

	protected function renderDefault($name)
	{
		return '(default: ' . $this->default[$name] . ')';
	}

	protected function replaceContentList($config)
	{
		foreach($config as $placeholder => $value) {
			$this->replaceContent($value, $placeholder);
		}
	}

	protected function replaceContent($value, $placeholder)
	{
		foreach ($this->paths as $file) {
			$content = $this->loadFile($file);
			$content = $this->replacePlaceholder($placeholder, $value, $content);
			$this->saveFile($file, $content);
		}
	}

	protected function replacePlaceholder($placeholder, $value, $content)
	{
		do {
			$contentOld = $content;
			$content = str_replace($placeholder, $value, $content);
		} while($contentOld != $content);
		return $content;
	}

	protected function isPlaceholderExists($placeholder)
	{
		foreach ($this->paths as $file) {
			$content = $this->loadFile($file);
			$isExists = strpos($content, $placeholder) !== false;
			if($isExists) {
				return true;
			}
		}
		return false;
	}

	protected function loadFile($name)
	{
		$file = $this->getFileName($name);
		$content = file_get_contents($file);
		return $content;
	}

	protected function saveFile($name, $content)
	{
		$file = $this->getFileName($name);
		file_put_contents($file, $content);
	}

	protected function removeFile($name)
	{
		$file = $this->getFileName($name);
		return @unlink($file);
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

	protected function removeDir($name)
	{
		$file = $this->getFileName($name);
		return @rmdir($file);
	}

	protected function getFileName($name)
	{
		$file = $this->root . '/' . $name;
		$file = FileHelper::normalizePath($file);
		return $file;
	}

	protected function setDefault($config) {
		foreach($this->default as $name => $defaultValue) {
			$value = $config[$name];
			if(empty($value) && $value !== 0) {
				$config[$name] = $defaultValue;
			}
		}
		return $config;
	}

}
