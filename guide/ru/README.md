Инициализация проекта
===

## Параметры командной строки

### Проект

Имя: project

Значение: числовой индекс проекта

### Домен

Имя: domain

Значение: массив

* base
* frontend
* backend
* api
* static

### База данных

Имя: db

Значение: массив

* driver
* host
* username
* password
* dbname

### Окружение

Имя: env

Значение: одно из следующих значений

* prod
* dev
* test

### Перезапись файлов

Имя: overwrite

Значение: одно из следующих значений

* y (Yes)
* n (No)
* a (All)
* q (Quit)

### Пример

```
php init project=2 db[driver]=mysql db[host]=localhost db[username]=root db[password]=123456 db[dbname]=wooppay env[env]=dev domain[base]=wooppay.yii overwrite=a
```
