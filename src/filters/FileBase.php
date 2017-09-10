<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;
use yii2lab\helpers\yii\FileHelper;

abstract class FileBase extends Base {

	protected function showInput($name, $placeholder = null, $message = null, $isForce = false) {
		if(empty($message)) {
			$message = $name;
		}
		if(empty($placeholder)) {
			$placeholder = $this->getPlaceholderFromMask($name);
		}
		if($this->isPlaceholderExists($placeholder) || $isForce) {
			$config = Enter::display($message . ' ' . $this->renderDefault($name));
		} else {
			$config = $this->getDefault($name);
		}
		return $config;
	}

	protected function showSelect($name, $placeholder = null, $message = null) {
		if(empty($message)) {
			$message = $name;
		}
		if(empty($placeholder)) {
			$placeholder = $this->getPlaceholderFromMask($name);
		}
		if($this->isPlaceholderExists($placeholder)) {
			$enum = $this->initInstance->getConfigItem('enum.' . $name);
			$config = Question::display($message . ' ' . $this->renderDefault($name), $enum);
		} else {
			$config = $this->getDefault($name);
		}
		return $config;
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

	protected function isFile($name)
	{
		$file = $this->getFileName($name);
		return file_exists($file);
	}

	protected function chmodFile($name, $mode)
	{
		$file = $this->getFileName($name);
		return @chmod($file, $mode);
	}

	protected function loadFile($name)
	{
		$file = $this->getFileName($name);
		$content = FileHelper::load($file);
		return $content;
	}

	protected function saveFile($name, $content)
	{
		$file = $this->getFileName($name);
		FileHelper::save($file, $content);
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

	protected function isDir($name)
	{
		$file = $this->getFileName($name);
		return @is_dir($file);
	}

	protected function getFileName($name)
	{
		$file = $this->initInstance->getRoot() . '/' . $name;
		$file = FileHelper::normalizePath($file);
		return $file;
	}

}
