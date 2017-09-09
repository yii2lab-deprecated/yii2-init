<?php

namespace yii2lab\init\helpers;

use yii\helpers\ArrayHelper;

class Env {

	public static function getOneParam($name)
	{
		$params = self::getParams();
		return ArrayHelper::getValue($params, $name);
	}

	public static function getParams()
	{
		$rawParams = [];
		if (isset($_SERVER['argv'])) {
			$rawParams = $_SERVER['argv'];
			array_shift($rawParams);
		}
		$params = [];
		foreach ($rawParams as $param) {
			if (preg_match('/^--(\w+)(=(.*))?$/', $param, $matches)) {
				$name = $matches[1];
				$params[$name] = isset($matches[3]) ? $matches[3] : true;
			} else {
				$params[] = $param;
			}
		}
		return $params;
	}

}
