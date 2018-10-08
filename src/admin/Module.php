<?php

namespace yii2lab\init\admin;

use common\enums\rbac\PermissionEnum;
use yii2lab\app\domain\enums\AppPermissionEnum;
use yii2lab\applicationTemplate\common\enums\ApplicationPermissionEnum;
use yii2lab\extension\web\helpers\Behavior;

/**
 * Class Module
 * 
 * @package yii2lab\init\admin
 */
class Module extends \yii\base\Module {

    public function behaviors()
    {
        return [
            'access' => Behavior::access(ApplicationPermissionEnum::BACKEND_ALL),
        ];
    }

}