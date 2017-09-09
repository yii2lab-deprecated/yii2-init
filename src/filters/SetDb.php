<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;

class SetDb extends Base {

	public $drivers = [
		'mysql' => 'MySql',
		'pgsql' => 'Postgres',
	];
	public $default = [
		'driver' => 'pgsql',
		'host' => 'dbweb',
		'username' => 'logging',
		'password' => 'moneylogger',
		'dbname' => 'wooppay',
		'defaultSchema' => 'salempay',
	];

	public function run()
	{
		$config = $this->default;
		if(Question::confirm('DB configure?')) {
			$config['driver'] = $this->selectDriver();
			$config['host'] = Enter::display('host (default: ' . $this->default['host'] . ')');
			$config['username'] = Enter::display('username (default: ' . $this->default['username'] . ')');
			$config['password'] = Enter::display('password (default: ' . $this->default['password'] . ')');
			$config['dbname'] = Enter::display('dbname (default: ' . $this->default['dbname'] . ')');
			$config['defaultSchema'] = Enter::display('defaultSchema (default: ' . $this->default['defaultSchema'] . ')');
		}
		$config = $this->setDefault($config);
		$this->replaceContentList([
			'_DRIVER_DB_PLACEHOLDER_' => $config['driver'],
			'_HOST_DB_PLACEHOLDER_' => $config['host'],
			'_USER_DB_PLACEHOLDER_' => $config['username'],
			'_PASSWORD_DB_PLACEHOLDER_' => $config['password'],
			'_DBNAME_DB_PLACEHOLDER_' => $config['dbname'],
			'_SCHEMA_DB_PLACEHOLDER_' => $config['defaultSchema'],
		]);
	}

	private function selectDriver() {
		$answer = Question::display('Select DB driver (default: ' . $this->default['driver'] . ')', $this->drivers);
		return $answer;
	}

}
