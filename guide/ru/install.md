Установка
===

Устанавливаем зависимость:

```
composer require yii2lab/yii2-init
```

Объявляем консольный модуль (необязательно):

```php
return [
	'modules' => [
		// ...
		'environments' => 'yii2lab\init\console\Module',
		// ...
	],
];
```