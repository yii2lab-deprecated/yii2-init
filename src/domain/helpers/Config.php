<?php

namespace yii2lab\init\domain\helpers;

use yii\helpers\ArrayHelper;

class Config {
	
	const LEVEL_TO_ROOT = 6;
	const CONFIG_DIR = 'environments/config';
	const FILENAME = 'environments/config/main.php';
	
	public static function one($name = null)
	{
		$config = self::all();
		return ArrayHelper::getValue($config, $name);
	}
	
	public static function all()
	{
		$config = require(ROOT_DIR . DS . self::CONFIG_DIR . DS . 'main.php');
		/*foreach($config['projects'] as $projectName) {
		
		}*/
		return $config;
	}
	
}
