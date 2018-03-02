<?php

namespace yii2lab\init\admin\controllers;

use yii\web\Controller;
use yii2lab\init\domain\helpers\CheckYiiRequirements;

class RequirementsController extends Controller
{
	
	public function actionIndex()
	{
		$html = CheckYiiRequirements::getHtml();
		return $this->render('index', ['html' => $html]);
	}
	
}
