Командная строка
===

## Описание параметров

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
* defaultSchema

### Окружение

Имя: env

Значение: массив

* env
* debug

Параметр `env` может принимать одно из следующих значений:

* prod
* dev
* test

Параметр `debug` может принимать одно из следующих значений:

* 1
* 0

### Перезапись файлов

Имя: overwrite

Значение: одно из следующих значений

* y (Yes)
* n (No)
* a (All)
* q (Quit)

## Параметры командной строки

```
php init project=0 db[driver]=pgsql db[host]=dbweb db[username]=logging db[password]=moneylogger db[dbname]=qrpay db[defaultSchema]=qrpay env[env]=dev env[debug]=1 domain[frontend]=qr.yii domain[static]=qr.yii domain[backend]=admin.qr.yii domain[api]=api.qr.yii overwrite=a
```
