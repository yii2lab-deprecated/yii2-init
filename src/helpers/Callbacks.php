<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;

class Callbacks {

	private static $root;
	private static $appList = [
		'frontend',
		'backend',
		'api',
	];

	static function run($root, $env)
	{
		self::$root = $root;
		$env['setWritable'] = self::getWritableDirs($env['setWritable']);
		$callbacks = [
			'setCookieValidationKey',
			'setWritable',
			'setExecutable',
			'createSymlink',

			'setEnv',
			'setMainDomain',
			'setCoreDomain',
			'setDb',
		];
		foreach ($callbacks as $callback) {
			if (!empty($env[$callback])) {
				Callbacks::$callback($env[$callback]);
			}
		}
	}
	
	private static function getWritableDirs($paths = [])
	{
		$rootDirs = scandir(self::$root);
		$appList = [];
		$exclude = ['vendor', 'common', 'environments'];
		foreach($rootDirs as $dir) {
			if($dir[0] != '.' && is_dir(self::$root . "/$dir") && !in_array($dir, $exclude)) {
				$appList[] = $dir;
			}
		}
		foreach($appList as $app) {
			if(is_dir(self::$root . "/$app/runtime")) {
				$paths[] = "$app/runtime";
			}
			if(is_dir(self::$root . "/$app/web/assets")) {
				$paths[] = "$app/web/assets";
			}
		}
		$paths = array_unique($paths);
		return $paths;
	}
	
	private static function setWritable($paths)
	{
		foreach ($paths as $writable) {
			if (is_dir(self::$root . "/$writable")) {
				if (@chmod(self::$root . "/$writable", 0777)) {
					echo "      chmod 0777 $writable\n";
				} else {
					Error::line("Operation chmod not permitted for directory $writable.");
				}
			} else {
				Error::line("Directory $writable does not exist.");
			}
		}
	}

	private static function setExecutable($paths)
	{
		foreach ($paths as $executable) {
			if (file_exists(self::$root . "/$executable")) {
				if (@chmod(self::$root . "/$executable", 0755)) {
					echo "      chmod 0755 $executable\n";
				} else {
					Error::line("Operation chmod not permitted for $executable.");
				}
			} else {
				Error::line("$executable does not exist.");
			}
		}
	}

	private static function generateCookieValidationKey($length = 32)
	{
		$bytes = openssl_random_pseudo_bytes($length);
		$key = strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
		return $key;
	}

	private static function setCookieValidationKey($paths)
	{
		foreach ($paths as $file) {
			echo "   generate cookie validation key in $file\n";
			$file = self::$root . '/' . $file;
			$content = file_get_contents($file);
			foreach(self::$appList as $app) {
				$placeholder = '_' . strtoupper($app) . '_COOKIE_VALIDATION_KEY_PLACEHOLDER_';
				$key = self::generateCookieValidationKey();
				$content = str_replace($placeholder, $key, $content);
			}
			file_put_contents($file, $content);
		}
	}

	private static function setEnv($paths)
	{
		$answer = Question::display('Select env', ['prod', 'dev']);
		$value = $answer == 'p' ? 'prod' : 'dev';
		self::replaceContent($paths, $value, '_YII_ENV_PLACEHOLDER_');
		$value = $answer == 'p' ? 'false' : 'true';
		self::replaceContent($paths, $value, '_YII_DEBUG_PLACEHOLDER_');
	}

	private static function setMainDomain($paths)
	{
		$answer = Enter::display('Enter site domain');
		self::replaceContent($paths, $answer, '_MAIN_DOMAIN_PLACEHOLDER_');
	}

	private static function setCoreDomain($paths)
	{
		$answer = Enter::display('Enter core domain');
		self::replaceContent($paths, $answer, '_CORE_DOMAIN_PLACEHOLDER_');
	}

	private static function setDb($paths)
	{
		$answer = Question::display('Select DB driver', ['mysql', 'pgsql']);
		$value = $answer == 'm' ? 'mysql' : 'pgsql';
		self::replaceContent($paths, $value, '_DRIVER_DB_PLACEHOLDER_');
		$answer = Enter::display('Enter DB user');
		self::replaceContent($paths, $answer, '_USER_DB_PLACEHOLDER_');
		$answer = Enter::display('Enter DB password');
		self::replaceContent($paths, $answer, '_PASSWORD_DB_PLACEHOLDER_');
	}

	private static function replaceContent($paths, $value, $placeholder)
	{
		foreach ($paths as $file) {

			$file = self::$root . '/' . $file;
			$content = file_get_contents($file);
			foreach(self::$appList as $app) {
				$content = str_replace($placeholder, $value, $content);
			}
			file_put_contents($file, $content);
		}
	}

	private static function createSymlink($links)
	{
		foreach ($links as $link => $target) {
			//first removing folders to avoid errors if the folder already exists
			@rmdir(self::$root . "/" . $link);
			//next removing existing symlink in order to update the target
			if (is_link(self::$root . "/" . $link)) {
				@unlink(self::$root . "/" . $link);
			}
			if (@symlink(self::$root . "/" . $target, self::$root . "/" . $link)) {
				echo "      symlink " . self::$root . "/$target " . self::$root . "/$link\n";
			} else {
				Error::line("Cannot create symlink " . self::$root . "/$target " . self::$root . "/$link.");
			}
		}
	}


}
