<?php

namespace yii2lab\init\filters;

class Base {

	public $root;
	public $paths;
	public $appList;
	public $default;

	protected function replaceContentList($config)
	{
		foreach($config as $placeholder => $value) {
			$this->replaceContent($value, $placeholder);
		}
	}

	protected function replaceContent($value, $placeholder)
	{
		foreach ($this->paths as $file) {
			$file = $this->root . '/' . $file;
			$content = file_get_contents($file);
			foreach($this->appList as $app) {
				$content = str_replace($placeholder, $value, $content);
			}
			file_put_contents($file, $content);
		}
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
