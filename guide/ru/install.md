Установка
===

Устанавливаем зависимость:

```
composer require yii2lab/yii2-init
```

В корне проекта создаем файл `init` с кодом:

```php
#!/usr/bin/env php
<?php

use yii2lab\init\domain\helpers\Init;
use yii2lab\app\App;

$name = 'console';
$path = '.';
defined('YII_ENV') || define('YII_ENV', 'test');

require_once(__DIR__ . '/' . $path . '/vendor/yii2lab/yii2-app/src/App.php');

App::init($name);

Init::run();
```
