<?php

namespace yii2lab\init\console\controllers;

use yii2lab\console\yii\console\Controller;
use yii2lab\init\domain\helpers\CheckYiiRequirements;

class RequirementsController extends Controller
{
	
	/**
	 * Check project requirements
	 */
	public function actionIndex()
	{
		CheckYiiRequirements::run()->render();
	}
	
}
