<?php

namespace yii2lab\init\helpers;

class Callbacks {

	public $root;
	private $appList = [
		'frontend',
		'backend',
		'api',
	];

	function run($env)
	{
		$env['setWritable'] = $this->getWritableDirs($env['setWritable']);
		$callbacks = [
			'setCookieValidationKey' => 'yii2lab\init\filters\SetCookieValidationKey',
			'setWritable' => 'yii2lab\init\filters\SetWritable',
			'setExecutable' => 'yii2lab\init\filters\SetExecutable',
			'createSymlink' => 'yii2lab\init\filters\CreateSymlink',

			'setEnv' => 'yii2lab\init\filters\SetEnv',
			'setMainDomain' => 'yii2lab\init\filters\SetMainDomain',
			'setCoreDomain' => 'yii2lab\init\filters\SetCoreDomain',
			'setDb' => 'yii2lab\init\filters\SetDb',
		];
		foreach ($callbacks as $callback => $class) {
			if (!empty($env[$callback])) {
				$filter = new $class;
				$filter->root = $this->root;
				$filter->paths = $env[$callback];
				$filter->appList = $this->appList;
				$filter->run();
			}
		}
	}
	
	private function getWritableDirs($paths = [])
	{
		$rootDirs = scandir($this->root);
		$appList = [];
		$exclude = ['vendor', 'common', 'environments'];
		foreach($rootDirs as $dir) {
			if($dir[0] != '.' && is_dir($this->root . "/$dir") && !in_array($dir, $exclude)) {
				$appList[] = $dir;
			}
		}
		foreach($appList as $app) {
			if(is_dir($this->root . "/$app/runtime")) {
				$paths[] = "$app/runtime";
			}
			if(is_dir($this->root . "/$app/web/assets")) {
				$paths[] = "$app/web/assets";
			}
		}
		$paths = array_unique($paths);
		return $paths;
	}

}
