<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\extension\scenario\base\BaseScenario;

class ServerStatic extends BaseScenario {

	public $default = [];
	
	public function run() {
		$config = $this->getData();
		$staticConfig = $this->default;
		if(empty($staticConfig['domain'])) {
			$staticConfig['domain'] = $config['url']['frontend'];
		}
		$config['servers']['static'] = $staticConfig;
		$this->setData($config);
	}
	
}
