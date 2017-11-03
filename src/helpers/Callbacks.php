<?php

namespace yii2lab\init\helpers;

use yii\helpers\Inflector;
use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;

class Callbacks {
	
	const BASE_NAMESPACE = 'yii2lab\init\filters';
	
	public $projectConfig;

	function run()
	{
		foreach ($this->projectConfig as $callback => $params) {
			Output::line();
			Output::pipe(Inflector::titleize($callback));
			Output::line();
			self::runFilter($callback, $params);
		}
	}
	
	public static function runFilter($class, $params = null) {
		/** @var \yii2lab\init\filters\Base $filter */
		$class = self::normalizeClassName($class);
		if (!class_exists($class)) {
			Error::line('Class not exists!');
		}
		$filter = new $class;
		return $filter->run($params);
	}
	
	private static function normalizeClassName($class) {
		$class = self::BASE_NAMESPACE . '\\' . ucfirst($class);
		return $class;
	}
	
}
