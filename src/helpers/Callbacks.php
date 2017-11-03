<?php

namespace yii2lab\init\helpers;

use Codeception\Util\Locator;
use yii\helpers\Inflector;
use yii2lab\console\helpers\Output;

class Callbacks {
	
	const BASE_NAMESPACE = 'yii2lab\init\filters';
	
	public $projectConfig;

	function run()
	{
		foreach ($this->projectConfig as $callback => $list) {
			$class = self::normalizeClassName($callback);
			if (class_exists($class)) {
				Output::line();
				Output::pipe(Inflector::titleize($callback));
				Output::line();
				$this->createFilter($class, $list);
			}
		}
	}
	
	public static function runFilter($class, $params = null) {
		/** @var \yii2lab\init\filters\Base $filter */
		$class = self::normalizeClassName($class);
		$filter = new $class;
		return $filter->run($params);
	}
	
	private static function normalizeClassName($class) {
		//if(!Locator::isClass($class)) {
			$class = self::BASE_NAMESPACE . '\\' . ucfirst($class);
		//}
		return $class;
	}
	
	protected function createFilter($class, $list) {
		/** @var \yii2lab\init\filters\Base $filter */
		$filter = new $class;
		$filter->paths = $list;
		$filter->run();
	}
}
