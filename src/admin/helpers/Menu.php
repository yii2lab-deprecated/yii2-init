<?php

namespace yii2lab\init\admin\helpers;

use common\enums\rbac\PermissionEnum;
use yii2lab\extension\menu\interfaces\MenuInterface;

class Menu implements MenuInterface {
	
	public function toArray() {
		return [
			'label' => ['init/requirements', 'title'],
			'url' => 'init/requirements',
			'module' => 'init',
		];
	}

}
