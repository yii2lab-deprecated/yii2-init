<?php

namespace yii2lab\init\domain\base;

use Yii;
use yii\base\Component;
use yii\helpers\ArrayHelper;
use yii2lab\extension\console\helpers\ArgHelper;
use yii2lab\init\domain\helpers\PlaceholderHelper;

abstract class BaseFilter extends Component {

	public $paths;
	public $default;
	public $argName;
	public $placeholderMask;
	
	/**
	 * @var PlaceholderHelper
	 */
	protected $placeholder;

	abstract public function run();
	
	public function init() {
		$this->placeholder = Yii::createObject([
			'class' => PlaceholderHelper::class,
			'paths' => $this->paths,
			'placeholderMask' => $this->placeholderMask,
		]);
	}
	
	protected function getArgData() {
		if(empty($this->argName)) {
			throw new \Exception('config "argName" not be set');
		}
		return ArgHelper::one($this->argName);
	}
	
	protected function getDefault($name)
	{
		return ArrayHelper::getValue($this->default, $name);
	}

	protected function setDefault($config) {
		if(empty($this->default)) {
			return $config;
		}
		foreach($this->default as $name => $defaultValue) {
			if(isset($config[$name])) {
				$value = $config[$name];
			} else {
				$value = $defaultValue;
			}
			if(empty($value) && $value !== 0) {
				$config[$name] = $defaultValue;
			}
		}
		return $config;
	}

	protected function inputData() {
		return [];
	}

	protected function userInput() {
		$arg = $this->getArgData();
		if(!empty($arg)) {
			$config = $arg;
		} else {
			$config = $this->inputData();
		}
		$config = $this->setDefault($config);
		return $config;
	}
	
}
