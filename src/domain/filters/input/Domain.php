<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\designPattern\filter\interfaces\FilterInterface;

class Domain implements FilterInterface {
	
	public $driver = [
		'primary' => 'disc',
		'slave' => 'disc',
	];
	
	public function run($config)
	{
		$config['domain']['driver'] = $this->driver;
		return $config;
	}
	
}
