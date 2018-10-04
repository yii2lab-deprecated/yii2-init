<?php

namespace yii2lab\init\domain\filters\input;

use yii2lab\app\admin\forms\UrlForm;
use yii2lab\extension\console\helpers\input\Enter;
use yii2lab\extension\console\helpers\Output;
use yii2lab\extension\common\helpers\UrlHelper;
use yii2lab\extension\yii\helpers\ArrayHelper;

class Url extends BaseFilter {

	public $argName = 'domain';
	
	public function run() {
		$config = $this->getData();
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
		$this->setData($config);
	}
	
	protected function inputData() {
		$config = Enter::form(UrlForm::class, $this->default);
		return $config;
	}

}
