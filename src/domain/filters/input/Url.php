<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\app\admin\forms\UrlForm;
use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\filter\interfaces\FilterInterface;
use yii2lab\helpers\UrlHelper;
use yii2lab\helpers\yii\ArrayHelper;

class Url extends BaseFilter implements FilterInterface {

	public $argName = 'domain';

	public function run($config)
	{
		$inputData = $this->userInput();
		$inputData = ArrayHelper::merge($this->default, $inputData);
		foreach($inputData as &$url) {
			$url = rtrim($url, SL) . SL;
			if(!UrlHelper::isAbsolute($url)) {
				$url = 'http://' . $url;
			}
		}
		Output::line();
		Output::arr($inputData);
		$config['url'] = $inputData;
		return $config;
	}

	protected function inputData() {
		$config = Enter::form(UrlForm::class, $this->default);
		return $config;
	}

}
