<?php

namespace yii2lab\init\domain\helpers;

use yii\helpers\ArrayHelper;

class Config {
	
	const CONFIG_DIR = 'environments/config';
	
	public static function one($name = null)
	{
		$config = self::all();
		return ArrayHelper::getValue($config, $name);
	}
	
	public static function all()
	{
		$config = require(ROOT_DIR . DS . self::CONFIG_DIR . DS . 'main.php');
		return $config;
	}
	
}
