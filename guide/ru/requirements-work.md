Механизм работы
===

У платформы есть свои системные требования, которые она предъявляет окружению.

Их можно дополнить проектными требованиями.
Описываются в файле `environments/config/requirements.php`.

Пример:

```php
return [
	[
		'name' => 'PDO extension',
		'mandatory' => true,
		'condition' => extension_loaded('pdo'),
		'by' => 'All DB-related classes',
	],
];
```

где:

* `name` - Отображаемое имя
* `mandatory` - критичность
* `condition` - условие
* `by` - пояснение, для чего это нужно
