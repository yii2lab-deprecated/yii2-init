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

$name = 'console';
$path = '.';

@include_once(__DIR__ . '/' . $path . '/vendor/yii2lab/yii2-app/src/App.php');

if(!class_exists(App::class)) {
	die('Run composer install');
}

App::init($name);

Init::run();
```
