<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\input\Select;
use yii2lab\console\helpers\Output;
use yii2mod\helpers\ArrayHelper;

class Init {

	private static $params;
	private static $root;
	private static $envs;
	private static $appList = [
		'frontend',
		'backend',
		'api',
	];
	private static $callbacks = [
		'setCookieValidationKey' => 'yii2lab\init\filters\SetCookieValidationKey',
		'setWritable' => 'yii2lab\init\filters\SetWritable',
		'setExecutable' => 'yii2lab\init\filters\SetExecutable',
		'createSymlink' => 'yii2lab\init\filters\CreateSymlink',
		'setEnv' => 'yii2lab\init\filters\SetEnv',
		'setMainDomain' => 'yii2lab\init\filters\SetMainDomain',
		'setCoreDomain' => 'yii2lab\init\filters\SetCoreDomain',
		'setDb' => 'yii2lab\init\filters\SetDb',
	];

	static function init($dir, $config)
	{
		Output::line();
		if (!extension_loaded('openssl')) {
			Output::line('The OpenSSL PHP extension is required by Yii2.');
			die();
		}

		self::$params = self::getParams();
		self::$root = str_replace('\\', '/', $dir);
		self::$envs = $config;

		Output::line("Yii Application Initialization Tool v1.0");

		$envName = self::getEnvName();

		self::initializationConfirm($envName);

		Output::pipe("Start initialization");

		$env = self::$envs[$envName];

		$copyFiles = new CopyFiles;
		$copyFiles->root = self::$root;
		$copyFiles->env = $env;
		$copyFiles->run($env);

		$callbacks = new Callbacks;
		$callbacks->root = self::$root;
		$callbacks->env = $env;
		$callbacks->appList = self::$appList;
		$callbacks->callbacks = self::$callbacks;
		$callbacks->run();

		Output::pipe("initialization completed!");
	}

	private static function getEnvName()
	{
		$envName = null;
		$envNames = array_keys(self::$envs);
		if (empty(self::$params['env']) || self::$params['env'] === '1') {
			$answer = Select::display('Which environment do you want the application to be initialized in?', $envNames, 0);
			$envName = ArrayHelper::first($answer);
		} else {
			$envName = self::$params['env'];
		}
		return $envName;
	}

	private static function initializationConfirm($envName)
	{
		if (empty(self::$params['env'])) {
			Question::confirm("Initialize the application under '{$envName}' environment?", 1);
			Output::line();
		}
	}
	
	private static function getParams()
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
