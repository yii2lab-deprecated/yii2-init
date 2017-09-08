<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\input\Enter;

class Callbacks {

	private static $root;
	private static $appList = [
		'frontend',
		'backend',
		'api',
	];

	function run($root, $env)
	{
		self::$root = $root;
		$env['setWritable'] = self::getWritableDirs($env['setWritable']);
		$callbacks = [
			'setCookieValidationKey',
			'setWritable',
			'setExecutable',
			'createSymlink',
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
	
	private function getWritableDirs($paths = [])
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
	
	private function setWritable($paths)
	{
		foreach ($paths as $writable) {
			if (is_dir(self::$root . "/$writable")) {
				if (@chmod(self::$root . "/$writable", 0777)) {
					echo "      chmod 0777 $writable\n";
				} else {
					Output::printError("Operation chmod not permitted for directory $writable.");
				}
			} else {
				Output::printError("Directory $writable does not exist.");
			}
		}
	}

	private function setExecutable($paths)
	{
		foreach ($paths as $executable) {
			if (file_exists(self::$root . "/$executable")) {
				if (@chmod(self::$root . "/$executable", 0755)) {
					echo "      chmod 0755 $executable\n";
				} else {
					Output::printError("Operation chmod not permitted for $executable.");
				}
			} else {
				Output::printError("$executable does not exist.");
			}
		}
	}

	private function generateCookieValidationKey($length = 32)
	{
		$bytes = openssl_random_pseudo_bytes($length);
		$key = strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
		return $key;
	}

	private function setCookieValidationKey($paths)
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

	private function setMainDomain($paths)
	{
		self::replaceContent($paths, 'Enter site domain', '_MAIN_DOMAIN_PLACEHOLDER_');
	}

	private function setCoreDomain($paths)
	{
		self::replaceContent($paths, 'Enter core domain', '_CORE_DOMAIN_PLACEHOLDER_');
	}

	private function setDb($paths)
	{
		self::replaceContent($paths, 'Enter DB user', '_USER_DB_PLACEHOLDER_');
		self::replaceContent($paths, 'Enter DB password', '_PASSWORD_DB_PLACEHOLDER_');
	}

	private function replaceContent($paths, $message, $placeholder)
	{
		foreach ($paths as $file) {
			$domain = Enter::display($message);
			$file = self::$root . '/' . $file;
			$content = file_get_contents($file);
			foreach(self::$appList as $app) {
				$content = str_replace($placeholder, $domain, $content);
			}
			file_put_contents($file, $content);
		}
	}

	private function createSymlink($links)
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
				Output::printError("Cannot create symlink " . self::$root . "/$target " . self::$root . "/$link.");
			}
		}
	}


}
