<?php

namespace yii2lab\init\filters;

class Base {

	public $root;
	public $paths;
	public $appList;

	protected function replaceContent($paths, $value, $placeholder)
	{
		foreach ($paths as $file) {
			$file = $this->root . '/' . $file;
			$content = file_get_contents($file);
			foreach($this->appList as $app) {
				$content = str_replace($placeholder, $value, $content);
			}
			file_put_contents($file, $content);
		}
	}

}
