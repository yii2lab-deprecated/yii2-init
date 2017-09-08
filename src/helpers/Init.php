<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\input\Select;
use yii2lab\console\helpers\Output;

class Init {

	private static $params;
	private static $root;
	private static $envs;
	
	static function init($dir, $config)
	{
		if (!extension_loaded('openssl')) {
			die('The OpenSSL PHP extension is required by Yii2.');
		}

		self::$params = self::getParams();
		self::$root = str_replace('\\', '/', $dir);
		self::$envs = $config;

		Output::line();
		Output::line("Yii Application Initialization Tool v1.0");

		$envName = self::getEnvName();
		self::isValidEnvName($envName);

		self::initializationConfirm($envName);

		Output::line("  Start initialization ...");

		$env = self::getEnvArray($envName);
		CopyFiles::copyAllFiles(self::$root, $env, self::$params['overwrite']);
		$env['path'] = 'common';
		CopyFiles::copyAllFiles(self::$root, $env, self::$params['overwrite']);
		Callbacks::run(self::$root, $env);

		echo "\n  ... initialization completed.\n\n";
	}

	private static function isValidEnvName($envName)
	{
		$envNames = array_keys(self::$envs);
		if (!in_array($envName, $envNames)) {
			$envsList = implode(', ', $envNames);
			Output::line("$envName is not a valid environment. Try one of the following: $envsList.");
			exit(2);
		}
	}
	
	private static function getEnvName()
	{
		$envName = null;
		$envNames = array_keys(self::$envs);
		if (empty(self::$params['env']) || self::$params['env'] === '1') {
			$answer = Select::display('Which environment do you want the application to be initialized in?', $envNames, 0);
			$envName = $answer[0];
		} else {
			$envName = self::$params['env'];
		}
		return $envName;
	}
	
	private static function getEnvArray($envName)
	{
		$env = self::$envs[$envName];
		return $env;
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
