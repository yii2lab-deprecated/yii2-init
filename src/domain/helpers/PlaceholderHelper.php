<?php

namespace yii2lab\init\domain\helpers;

use yii2lab\extension\yii\helpers\FileHelper;

class PlaceholderHelper {
	
	public $paths = [];
	public $placeholderMask;
	
	public function saveData($config) {
		$replacement = $this->generateReplacement($config);
		$this->replaceContentList($replacement);
	}
	
	public function generateReplacement($config) {
		$result = [];
		foreach($config as $name => $data) {
			$placeholder = $this->getPlaceholderFromMask($name);
			$result[$placeholder] = $data;
		}
		return $result;
	}
	
	public function replaceContentList($config)
	{
		foreach($config as $placeholder => $value) {
			$this->replaceContent($value, $placeholder);
		}
	}
	
	private function getPlaceholderFromMask($name) {
		$placeholder = str_replace('{name}', strtoupper($name), $this->placeholderMask);
		$systemPlaceholderMask = Config::one('system.placeholderMask');
		$placeholder = str_replace('{name}', strtoupper($placeholder), $systemPlaceholderMask);
		return $placeholder;
	}
	
	private function replaceContent($value, $placeholder)
	{
		foreach ($this->paths as $file) {
			$content = FileSystemHelper::loadFile($file);
			$content = $this->replacePlaceholder($placeholder, $value, $content);
			FileSystemHelper::saveFile($file, $content);
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
	
	private function isPlaceholderExists($placeholder)
	{
		foreach ($this->paths as $file) {
			$content = FileSystemHelper::loadFile($file);
			$isExists = strpos($content, $placeholder) !== false;
			if($isExists) {
				return true;
			}
		}
		return false;
	}
}
