<?php

namespace yii2lab\init\domain\filters\store;

use yii2lab\designPattern\filter\interfaces\FilterInterface;
use yii2lab\store\Store;

class EnvLocalConfig implements FilterInterface {

	public $fileAlias = '@common/config/env-local.php';
	
	public function run($config)
	{
		$store = new Store('php');
		$store->save($this->fileAlias, $config);
		return $config;
	}

}
