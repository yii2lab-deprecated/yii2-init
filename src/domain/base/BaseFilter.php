<?php

namespace yii2lab\init\domain\base;

use yii\helpers\ArrayHelper;
use yii2lab\console\helpers\ArgHelper;
use yii2lab\init\domain\helpers\Config;

abstract class BaseFilter {

	public $paths;
	public $default;
	public $argName;
	public $placeholderMask;

	abstract public function run();
	
	protected function getArgData() {
		if(empty($this->argName)) {
			throw new \Exception('config "argName" not be set');
		}
		return ArgHelper::one($this->argName);
	}

	protected function generateReplacement($config) {
		$result = [];
		foreach($config as $name => $data) {
			$placeholder = $this->getPlaceholderFromMask($name);
			$result[$placeholder] = $data;
		}
		return $result;
	}

	protected function getPlaceholderFromMask($name) {
		$placeholder = str_replace('{name}', strtoupper($name), $this->placeholderMask);
		$systemPlaceholderMask = Config::one('system.placeholderMask');
		$placeholder = str_replace('{name}', strtoupper($placeholder), $systemPlaceholderMask);
		return $placeholder;
	}

	protected function replacePlaceholder($placeholder, $value, $content)
	{
		do {
			$contentOld = $content;
			$content = str_replace($placeholder, $value, $content);
		} while($contentOld != $content);
		return $content;
	}

	protected function getDefault($name)
	{
		return ArrayHelper::getValue($this->default, $name);
	}

	protected function renderDefault($name)
	{
		return '(default: ' . $this->getDefault($name) . ')';
	}

	protected function setDefault($config) {
		if(empty($this->default)) {
			return $config;
		}
		foreach($this->default as $name => $defaultValue) {
			if(isset($config[$name])) {
				$value = $config[$name];
			} else {
				$value = $defaultValue;
			}
			if(empty($value) && $value !== 0) {
				$config[$name] = $defaultValue;
			}
		}
		return $config;
	}

	protected function inputData() {
		return [];
	}

	protected function userInput() {
		$arg = $this->getArgData();
		if(!empty($arg)) {
			$config = $arg;
		} else {
			$config = $this->inputData();
		}
		$config = $this->setDefault($config);
		return $config;
	}

}