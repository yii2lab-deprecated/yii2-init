<?php

namespace yii2lab\init\helpers;

class Init {

	private static $params;
	private static $root;
	private static $envs;
	
	function init($dir, $config)
	{
		if (!extension_loaded('openssl')) {
			die('The OpenSSL PHP extension is required by Yii2.');
		}

		self::$params = self::getParams();
		self::$root = str_replace('\\', '/', $dir);
		self::$envs = $config;
		
		echo "Yii Application Initialization Tool v1.0\n\n";

		$envName = self::getEnvName();
		self::isValidEnvName($envName);

		self::initializationConfirm($envName);

		echo "\n  Start initialization ...\n\n";

		$env = self::getEnvArray($envName);
		CopyFiles::copyAllFiles(self::$root, $env, self::$params['overwrite']);
		$env['path'] = 'common';
		CopyFiles::copyAllFiles(self::$root, $env, self::$params['overwrite']);
		Callbacks::run(self::$root, $env);

		echo "\n  ... initialization completed.\n\n";
	}

	private function isValidEnvName($envName)
	{
		$envNames = array_keys(self::$envs);
		if (!in_array($envName, $envNames)) {
			$envsList = implode(', ', $envNames);
			echo "\n  $envName is not a valid environment. Try one of the following: $envsList. \n";
			exit(2);
		}
	}
	
	private function getEnvName()
	{
		$envName = null;
		$envNames = array_keys(self::$envs);
		if (empty(self::$params['env']) || self::$params['env'] === '1') {
			echo "Which environment do you want the application to be initialized in?\n\n";
			foreach ($envNames as $i => $name) {
				echo "  [$i] $name\n";
			}
			echo "\n  Your choice [0-" . (count(self::$envs) - 1) . ', or "q" to quit] ';
			$answer = trim(fgets(STDIN));
			if (!ctype_digit($answer) || !in_array($answer, range(0, count(self::$envs) - 1))) {
				echo "\n  Quit initialization.\n";
				exit(0);
			}
			if (isset($envNames[$answer])) {
				$envName = $envNames[$answer];
			}
		} else {
			$envName = self::$params['env'];
		}
		return $envName;
	}
	
	private function getEnvArray($envName)
	{
		$env = self::$envs[$envName];
		return $env;
	}
	
	private function initializationConfirm($envName)
	{
		if (empty(self::$params['env'])) {
			echo "\n  Initialize the application under '{$envName}' environment? [yes|no] ";
			$answer = trim(fgets(STDIN));
			if (strncasecmp($answer, 'y', 1)) {
				echo "\n  Quit initialization.\n";
				exit(0);
			}
		}
	}
	
	private function getParams()
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
