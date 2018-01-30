<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\designPattern\filter\interfaces\FilterInterface;

class ServerStatic implements FilterInterface {

	public $default = [];
	
	public function run($config)
	{
		$staticConfig = $this->default;
		if(empty($staticConfig['domain'])) {
			$staticConfig['domain'] = $config['url']['frontend'];
		}
		$config['servers']['static'] = $staticConfig;
		return $config;
	}

}
