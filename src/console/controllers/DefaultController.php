<?php

namespace yii2lab\init\console\controllers;

use yii2lab\extension\console\base\Controller;
use yii2lab\init\domain\helpers\Init;

class DefaultController extends Controller
{
	
	/**
	 * Init project
	 */
	public function actionIndex()
	{
		Init::run();
	}
	
}
