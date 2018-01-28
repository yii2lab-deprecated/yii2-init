<?php

namespace yii2lab\init\domain\helpers;

use yii\helpers\Inflector;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\command\helpers\CommandHelper;

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
	
}
