<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\designPattern\scenario\base\BaseScenario;

class Domain extends BaseScenario {
	
	public $driver = [
		'primary' => 'disc',
		'slave' => 'disc',
	];
	
	public function run() {
		$config = $this->getData();
		$config['domain']['driver'] = $this->driver;
		$this->setData($config);
	}
	
}
