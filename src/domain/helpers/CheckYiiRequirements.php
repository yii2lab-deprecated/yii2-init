<?php

namespace yii2lab\init\domain\helpers;

use Imagick;
use yii\helpers\ArrayHelper;
use YiiRequirementChecker;

class CheckYiiRequirements {
	
	public static function getHtml()
	{
		ob_start();
		$requirementsChecker = self::checkMisc();
		$requirementsChecker->render();
		$html = ob_get_contents();
		ob_end_clean();
		$html = str_replace('<div class="container">', '<div>', $html);
		$html = str_replace('<hr>', '', $html);
		$html = self::stripTag($html, 'style');
		$html = self::stripTag($html, 'footer');
		$html = self::stripTag($html, 'title');
		$html = self::stripTag($html, 'header');
		return $html;
	}
	
	public static function run()
	{
		return self::checkMisc();
	}
	
	private static function stripTag($html, $tag)
	{
		$html = preg_replace('#<'.$tag.'[^>]*>.*?</'.$tag.'>#is', '', $html);
		return $html;
	}
	
	private static function checkMisc()
	{
		$requirementsChecker = self::createInstance();
		$requirements = self::getAllRequirements($requirementsChecker);
		$requirementsChecker->checkYii();
		$requirementsChecker->check($requirements);
		return $requirementsChecker;
	}
	
	private static function getAllRequirements($requirementsChecker) {
		$requirements = [];
		$requirements = ArrayHelper::merge($requirements, self::getDatabaseRequirements());
		$requirements = ArrayHelper::merge($requirements, self::getCacheRequirements());
		$requirements = ArrayHelper::merge($requirements, self::getCaptchaRequirements());
		$requirements = ArrayHelper::merge($requirements, self::getPhpIniRequirements($requirementsChecker));
		$requirements = ArrayHelper::merge($requirements, self::getOpenSslRequirements());
		$requirements = ArrayHelper::merge($requirements, self::getProjectRequirements());
		return $requirements;
	}
	
	private static function createInstance() {
		require_once(VENDOR_DIR . SL . 'yiisoft/yii2/requirements/YiiRequirementChecker.php');
		/** @var YiiRequirementChecker $requirementsChecker */
		$requirementsChecker = new YiiRequirementChecker();
		return $requirementsChecker;
	}
	
	private static function getProjectRequirements() {
		$appRequirements = @include(ROOT_DIR . '/environments/config/requirements.php');
		if(empty($appRequirements)) {
			return [];
		}
		return $appRequirements;
	}
	
	private static function getDatabaseRequirements() {
		return [
			// Database :
			[
				'name' => 'PDO extension',
				'mandatory' => true,
				'condition' => extension_loaded('pdo'),
				'by' => 'All DB-related classes',
			],
			[
				'name' => 'PDO SQLite extension',
				'mandatory' => false,
				'condition' => extension_loaded('pdo_sqlite'),
				'by' => 'All DB-related classes',
				'memo' => 'Required for SQLite database.',
			],
			[
				'name' => 'PDO MySQL extension',
				'mandatory' => false,
				'condition' => extension_loaded('pdo_mysql'),
				'by' => 'All DB-related classes',
				'memo' => 'Required for MySQL database.',
			],
			[
				'name' => 'PDO PostgreSQL extension',
				'mandatory' => false,
				'condition' => extension_loaded('pdo_pgsql'),
				'by' => 'All DB-related classes',
				'memo' => 'Required for PostgreSQL database.',
			],
		];
	}
	
	private static function getCacheRequirements() {
		return [
			// Cache :
			[
				'name' => 'Memcache extension',
				'mandatory' => false,
				'condition' => extension_loaded('memcache') || extension_loaded('memcached'),
				'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html">MemCache</a>',
				'memo' => extension_loaded('memcached') ? 'To use memcached set <a href="http://www.yiiframework.com/doc-2.0/yii-caching-memcache.html#$useMemcached-detail">MemCache::useMemcached</a> to <code>true</code>.' : '',
			],
			[
				'name' => 'APC extension',
				'mandatory' => false,
				'condition' => extension_loaded('apc'),
				'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-caching-apccache.html">ApcCache</a>',
			],
		];
	}
	
	private static function getPhpIniRequirements(YiiRequirementChecker $requirementsChecker) {
		return [
			// PHP ini :
			'phpExposePhp' => [
				'name' => 'Expose PHP',
				'mandatory' => false,
				'condition' => $requirementsChecker->checkPhpIniOff("expose_php"),
				'by' => 'Security reasons',
				'memo' => '"expose_php" should be disabled at php.ini',
			],
			'phpAllowUrlInclude' => [
				'name' => 'PHP allow url include',
				'mandatory' => false,
				'condition' => $requirementsChecker->checkPhpIniOff("allow_url_include"),
				'by' => 'Security reasons',
				'memo' => '"allow_url_include" should be disabled at php.ini',
			],
			'phpSmtp' => [
				'name' => 'PHP mail SMTP',
				'mandatory' => false,
				'condition' => strlen(ini_get('SMTP')) > 0,
				'by' => 'Email sending',
				'memo' => 'PHP mail SMTP server required',
			],
		];
	}
	
	private static function getOpenSslRequirements() {
		return [
			'openSsl' => [
				'name' => 'OpenSSL',
				'mandatory' => false,
				'condition' => extension_loaded('openssl'),
				'by' => 'Generation cookie validation key',
				'memo' => 'The OpenSSL PHP extension is required by Yii2.',
			],
		];
	}
	
	private static function getCaptchaRequirements() {
		$gdMemo = $imagickMemo = 'Either GD PHP extension with FreeType support or ImageMagick PHP extension with PNG support is required for image CAPTCHA.';
		$gdOK = $imagickOK = false;
		
		if(extension_loaded('imagick')) {
			$imagick = new Imagick();
			$imagickFormats = $imagick->queryFormats('PNG');
			if(in_array('PNG', $imagickFormats)) {
				$imagickOK = true;
			} else {
				$imagickMemo = 'Imagick extension should be installed with PNG support in order to be used for image CAPTCHA.';
			}
		}
		
		if(extension_loaded('gd')) {
			$gdInfo = gd_info();
			if(!empty($gdInfo['FreeType Support'])) {
				$gdOK = true;
			} else {
				$gdMemo = 'GD extension should be installed with FreeType support in order to be used for image CAPTCHA.';
			}
		}
		
		/**
		 * Adjust requirements according to your application specifics.
		 */
		$requirements = [
			// CAPTCHA:
			[
				'name' => 'GD PHP extension with FreeType support',
				'mandatory' => false,
				'condition' => $gdOK,
				'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
				'memo' => $gdMemo,
			],
			[
				'name' => 'ImageMagick PHP extension with PNG support',
				'mandatory' => false,
				'condition' => $imagickOK,
				'by' => '<a href="http://www.yiiframework.com/doc-2.0/yii-captcha-captcha.html">Captcha</a>',
				'memo' => $imagickMemo,
			],
		];
		return $requirements;
	}
	
}
