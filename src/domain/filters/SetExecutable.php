<?php

namespace yii2lab\init\domain\filters;

use yii2lab\console\helpers\Error;
use yii2lab\console\helpers\Output;
use yii2lab\designPattern\command\interfaces\CommandInterface;
use yii2lab\init\domain\base\BaseFilter;
use yii2lab\init\domain\helpers\FileSystemHelper;

class SetExecutable extends BaseFilter implements CommandInterface {

	public function run()
	{
		foreach ($this->paths as $executable) {
			if (FileSystemHelper::isFile($executable)) {
				if (FileSystemHelper::chmodFile($executable, 0755)) {
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
