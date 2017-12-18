<?php

namespace yii2lab\init\helpers;

use yii\helpers\Inflector;
use yii2lab\console\helpers\Output;
use yii2lab\misc\helpers\CommandHelper;

class Filter {
	
	const BASE_NAMESPACE = 'yii2lab\init\filters';
	
	public static function all($projectConfig)
	{
		foreach ($projectConfig as $callback => $params) {
			if($callback != 'path') {
				Output::line();
				Output::pipe(Inflector::titleize($callback));
				Output::line();
				self::one($callback, $params);
			}
		}
	}
	
	private static function one($class, $params = null) {
		$class = self::normalizeClassName($class);
		$result = CommandHelper::run(['paths' => $params], $class);
		return $result;
	}
	
	private static function normalizeClassName($class) {
		$class = self::BASE_NAMESPACE . '\\' . ucfirst($class);
		return $class;
	}
	
}
