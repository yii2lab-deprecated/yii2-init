<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\designPattern\filter\interfaces\FilterInterface;
use yii2mod\helpers\ArrayHelper;

class Custom implements FilterInterface {
	
	public $segment;
	public $value = [];
	
	public function run($config)
	{
		ArrayHelper::set($config, $this->segment, $this->value);
		return $config;
	}

}
