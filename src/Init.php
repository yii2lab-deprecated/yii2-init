<?php

namespace yii2lab\init;

use yii2lab\init\helpers\Init as InitHelper;

class Init {

	function run($dir, $config)
	{
		InitHelper::init($dir, $config);
	}

}
