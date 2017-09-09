<?php

namespace yii2lab\init\helpers;

class Callbacks {

	public $root;
	public $env;
	public $appList;

	function run()
	{
		foreach ($this->env as $callback => $list) {
			$class = 'yii2lab\init\filters\\' . ucfirst($callback);
			if (class_exists($class)) {
				$filter = new $class;
				$filter->root = $this->root;
				$filter->paths = $list;
				$filter->appList = $this->appList;
				$filter->run();
			}
		}
	}

}
