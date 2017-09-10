<?php

namespace yii2lab\init\filters;

use yii2lab\console\helpers\input\Enter;
use yii2lab\console\helpers\input\Question;
use yii2lab\console\helpers\Output;

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
		$config = [];
		if(Question::confirm('DB configure?')) {
			$config = $this->userInput();
			Output::arr($config);
		} else {
			$config = $this->setDefault($config);
		}
		$this->saveData($config);
	}

	private function saveData($config) {
		$this->replaceContentList([
			'_DRIVER_DB_PLACEHOLDER_' => $config['driver'],
			'_HOST_DB_PLACEHOLDER_' => $config['host'],
			'_USER_DB_PLACEHOLDER_' => $config['username'],
			'_PASSWORD_DB_PLACEHOLDER_' => $config['password'],
			'_DBNAME_DB_PLACEHOLDER_' => $config['dbname'],
			'_SCHEMA_DB_PLACEHOLDER_' => $config['defaultSchema'],
		]);
	}

	private function userInput() {
		$config = $this->default;
		$config['driver'] = Question::display('Select DB driver '. $this->renderDefault('driver'), $this->drivers);
		$config['host'] = Enter::display('host '. $this->renderDefault('host'));
		$config['username'] = Enter::display('username '. $this->renderDefault('username'));
		$config['password'] = Enter::display('password '. $this->renderDefault('password'));
		$config['dbname'] = Enter::display('dbname '. $this->renderDefault('dbname'));
		if($config['driver'] == 'pgsql') {
			$config['defaultSchema'] = Enter::display('schema '. $this->renderDefault('defaultSchema'));
		}
		$config = $this->setDefault($config);
		return $config;
	}

}
