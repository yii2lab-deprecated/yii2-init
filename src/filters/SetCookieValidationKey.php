<?php

namespace yii2lab\init\filters;

class SetCookieValidationKey extends Base {

	public function run()
	{
		foreach ($this->paths as $file) {
			echo "   generate cookie validation key in $file\n";
			$file = $this->root . '/' . $file;
			$content = file_get_contents($file);
			foreach($this->appList as $app) {
				$placeholder = '_' . strtoupper($app) . '_COOKIE_VALIDATION_KEY_PLACEHOLDER_';
				$key = $this->generateCookieValidationKey();
				$content = str_replace($placeholder, $key, $content);
			}
			file_put_contents($file, $content);
		}
	}

	private function generateCookieValidationKey($length = 32)
	{
		$bytes = openssl_random_pseudo_bytes($length);
		$key = strtr(substr(base64_encode($bytes), 0, $length), '+/=', '_-.');
		return $key;
	}
}
