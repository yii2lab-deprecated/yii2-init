<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Error;

class setWritable extends Base {

	public function run()
	{
		foreach ($this->paths as $writable) {
			if (is_dir($this->root . "/$writable")) {
				if (@chmod($this->root . "/$writable", 0777)) {
					echo "      chmod 0777 $writable\n";
				} else {
					Error::line("Operation chmod not permitted for directory $writable.");
				}
			} else {
				Error::line("Directory $writable does not exist.");
			}
		}
	}

}
