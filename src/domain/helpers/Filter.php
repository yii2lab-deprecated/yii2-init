<?php

namespace yii2lab\init\domain\helpers;

use yii\helpers\Inflector;
use yii2lab\extension\console\helpers\Output;
use yii2lab\extension\scenario\helpers\ScenarioHelper;

class Filter {
	
	/**
	 * @param $filters
	 *
	 * @return array|mixed
	 * @throws \yii\base\InvalidConfigException
	 * @throws \yii\web\ServerErrorHttpException
	 */
	public static function allInput($filters)
	{
		$config = [];
		foreach ($filters as $definition) {
			if(array_key_exists('title', $definition)) {
				$title = $definition['title'];
				unset($definition['title']);
			} else {
				$className = basename($definition['class']);
				$title = Inflector::titleize($className);
			}
			if($title) {
				Output::line();
				Output::pipe($title);
				Output::line();
			}
			$config = ScenarioHelper::run($definition, $config);
		}
		return $config;
	}
}
