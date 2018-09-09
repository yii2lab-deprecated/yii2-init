<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\extension\scenario\base\BaseScenario;
use yii2mod\helpers\ArrayHelper;

class Custom extends BaseScenario {
	
	public $segment;
	public $value = [];
	
	public function run() {
		$config = $this->getData();
		ArrayHelper::set($config, $this->segment, $this->value);
		$this->setData($config);
	}
	
}
