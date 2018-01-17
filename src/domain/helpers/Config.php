<?php

namespace yii2lab\init\domain\helpers;

use yii\helpers\ArrayHelper;

class Config {
	
	const LEVEL_TO_ROOT = 6;
	const FILENAME = 'environments/config.php';
	
	public static function one($name = null)
	{
		$config = self::all();
		return ArrayHelper::getValue($config, $name);
	}
	
	public static function all()
	{
		$fileName = ROOT_DIR . DS . self::FILENAME;
		$config = require($fileName);
		return $config;
	}
	
}
