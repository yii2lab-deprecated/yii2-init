<?php

namespace yii2lab\init\base;

use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;
use yii2lab\init\helpers\Config;

abstract class PlaceholderBaseFilter extends FileBaseFilter {
	
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
			$enum = Config::one('enum.' . $name);
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
	
	private function replaceContent($value, $placeholder)
	{
		foreach ($this->paths as $file) {
			$content = $this->loadFile($file);
			$content = $this->replacePlaceholder($placeholder, $value, $content);
			$this->saveFile($file, $content);
		}
	}
	
	private function isPlaceholderExists($placeholder)
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

}
