<?php

namespace yii2lab\init\helpers;

use yii\helpers\Inflector;
use yii2lab\console\helpers\Output;

class Callbacks {

	public $env;

	function run()
	{
		foreach ($this->env as $callback => $list) {
			$class = 'yii2lab\init\filters\\' . ucfirst($callback);
			if (class_exists($class)) {
				Output::line();
				Output::pipe(Inflector::titleize($callback));
				Output::line();
				$this->createFilter($class, $list);
			}
		}
	}

	protected function createFilter($class, $list) {
		/** @var \yii2lab\init\filters\Base $filter */
		$filter = new $class;
		$filter->paths = $list;
		$filter->run();
	}
}
