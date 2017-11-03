<?php

namespace yii2lab\init\helpers;

use yii\helpers\Inflector;
use yii2lab\console\helpers\Output;

class Callbacks {
	
	const BASE_NAMESPACE = 'yii2lab\init\filters';
	
	public static function all($projectConfig)
	{
		foreach ($projectConfig as $callback => $params) {
			Output::line();
			Output::pipe(Inflector::titleize($callback));
			Output::line();
			self::one($callback, $params);
		}
	}
	
	public static function one($class, $params = null) {
		/** @var \yii2lab\init\filters\Base $filter */
		$class = self::normalizeClassName($class);
		$result = null;
		if (class_exists($class)) {
			$filter = new $class;
			$filter->paths = $params;
			$result = $filter->run($params);
		}
		return $result;
	}
	
	private static function normalizeClassName($class) {
		$class = self::BASE_NAMESPACE . '\\' . ucfirst($class);
		return $class;
	}
	
}
