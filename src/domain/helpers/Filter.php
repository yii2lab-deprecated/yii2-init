<?php

namespace yii2lab\init\domain\helpers;

use yii\helpers\Inflector;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\command\helpers\CommandHelper;
use yii2lab\designPattern\filter\helpers\FilterHelper;

class Filter {
	
	public static function all($filters)
	{
		foreach ($filters as $definition) {
			Output::line();
			$className = basename($definition['class']);
			$title = Inflector::titleize($className);
			Output::pipe($title);
			Output::line();
			CommandHelper::run($definition);
		}
	}
	
	public static function allInput($filters)
	{
		$config = [];
		foreach ($filters as $definition) {
			Output::line();
			$className = basename($definition['class']);
			$title = Inflector::titleize($className);
			Output::pipe($title);
			Output::line();
			$config = FilterHelper::run($definition, $config);
		}
		return $config;
	}
}
