<?php

namespace yii2lab\init\helpers;

class Callbacks {

	public $root;
	public $initInstance;
	public $env;
	public $appList;

	function run()
	{
		foreach ($this->env as $callback => $list) {
			$class = 'yii2lab\init\filters\\' . ucfirst($callback);
			if (class_exists($class)) {
				/** @var \yii2lab\init\filters\Base $filter */
				$filter = new $class;
				$filter->root = $this->root;
				$filter->initInstance = $this->initInstance;
				$filter->paths = $list;
				$filter->appList = $this->appList;
				$filter->run();
			}
		}
	}

}
