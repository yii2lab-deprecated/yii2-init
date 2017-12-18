<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;
use yii2lab\init\base\FileBaseFilter;
use yii2lab\misc\interfaces\CommandInterface;

class SetExecutable extends FileBaseFilter implements CommandInterface {

	public function run()
	{
		foreach ($this->paths as $executable) {
			if ($this->isFile($executable)) {
				if ($this->chmodFile($executable, 0755)) {
					Output::line("chmod 0755 $executable");
				} else {
					Error::line("Operation chmod not permitted for $executable.");
				}
			} else {
				Error::line("$executable does not exist.");
			}
		}
	}

}
