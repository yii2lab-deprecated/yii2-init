<?php

namespace yii2lab\init\helpers;

class Callbacks {

	public $root;
	public $env;
	public $appList;
	public $callbacks;

	function run()
	{
		foreach ($this->callbacks as $callback => $class) {
			if (!empty($this->env[$callback])) {
				$filter = new $class;
				$filter->root = $this->root;
				$filter->paths = $this->env[$callback];
				$filter->appList = $this->appList;
				$filter->run();
			}
		}
	}

}
