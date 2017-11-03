<?php

namespace yii2lab\init\helpers;

use yii\helpers\ArrayHelper;
use yii2lab\helpers\yii\FileHelper;

class Config {
	
	const LEVEL_TO_ROOT = 5;
	
	public static function one($name = null)
	{
		$config = self::all();
		return ArrayHelper::getValue($config, $name);
	}
	
	public static function all()
	{
		$fileName = self::root() . '/environments/config.php';
		$config = require($fileName);
		return $config;
	}
	
	public static function root()
	{
		return FileHelper::up(__DIR__, self::LEVEL_TO_ROOT);
	}

}
