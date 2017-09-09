<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\Error;

class CreateSymlink extends Base {

	public function run()
	{
		foreach ($this->paths as $link => $target) {
			//first removing folders to avoid errors if the folder already exists
			@rmdir($this->root . "/" . $link);
			//next removing existing symlink in order to update the target
			if (is_link($this->root . "/" . $link)) {
				@unlink($this->root . "/" . $link);
			}
			if (@symlink($this->root . "/" . $target, $this->root . "/" . $link)) {
				echo "      symlink " . $this->root . "/$target " . $this->root . "/$link\n";
			} else {
				Error::line("Cannot create symlink " . $this->root . "/$target " . $this->root . "/$link.");
			}
		}
	}

}
