<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\designPattern\filter\interfaces\FilterInterface;

class ServerMail implements FilterInterface {

	public $default = [];
	
	public function run($config)
	{
		$config['servers']['mail'] = $this->default;
		return $config;
	}

}
