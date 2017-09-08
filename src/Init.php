<?php

namespace yii2lab\init;

class Init {

	function run($dir, $config)
	{
		$path = __DIR__ . '/helpers/';
		require_once($path . 'Init.php');
		require_once($path . 'Callbacks.php');
		require_once($path . 'Output.php');
		require_once($path . 'CopyFiles.php');
		\yii2lab\init\helpers\Init::init($dir, $config);
	}

}