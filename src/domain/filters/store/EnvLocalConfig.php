<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\designPattern\scenario\base\BaseScenario;
use yii2lab\store\Store;

class EnvLocalConfig extends BaseScenario {

	public $fileAlias = '@common/config/env-local.php';
	
	public function run() {
		$config = $this->getData();
		$store = new Store('php');
		$store->save($this->fileAlias, $config);
		$this->setData($config);
	}
	
}
