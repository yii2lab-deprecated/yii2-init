<?php

namespace yii2lab\init\helpers;

use yii\helpers\Inflector;
use yii2lab\console\helpers\Output;
use yii2lab\helpers\Helper;
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
		$class = Helper::getClassName($class, self::BASE_NAMESPACE);
		$result = CommandHelper::run([
			'class' => $class,
			'paths' => $params
		]);
		return $result;
	}
	
}
