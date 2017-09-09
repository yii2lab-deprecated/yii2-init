<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Error;

class SetExecutable extends Base {

	public function run()
	{
		foreach ($this->paths as $executable) {
			if (file_exists($this->root . "/$executable")) {
				if (@chmod($this->root . "/$executable", 0755)) {
					echo "      chmod 0755 $executable\n";
				} else {
					Error::line("Operation chmod not permitted for $executable.");
				}
			} else {
				Error::line("$executable does not exist.");
			}
		}
	}

}
