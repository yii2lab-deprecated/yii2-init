<?php

namespace yii2lab\init\domain\helpers;

use yii2lab\extension\yii\helpers\FileHelper;

class FileSystemHelper {
	
	public static function isSymlinkFile($name)
	{
		$file = self::getFileName($name);
		return is_link($file);
	}
	
	public static function isFile($name)
	{
		$file = self::getFileName($name);
		return file_exists($file);
	}
	
	public static function chmodFile($name, $mode)
	{
		$file = self::getFileName($name);
		return @chmod($file, $mode);
	}
	
	public static function loadFile($name)
	{
		$file = self::getFileName($name);
		$content = FileHelper::load($file);
		return $content;
	}
	
	public static function saveFile($name, $content)
	{
		$file = self::getFileName($name);
		FileHelper::save($file, $content);
	}
	
	public static function removeFile($name)
	{
		$file = self::getFileName($name);
		return @unlink($file);
	}
	
	public static function removeDir($name)
	{
		$file = self::getFileName($name);
		return @rmdir($file);
	}
	
	public static function isDir($name)
	{
		$file = self::getFileName($name);
		return @is_dir($file);
	}
	
	public static function getFileName($name)
	{
		$file = ROOT_DIR . DS . $name;
		$file = FileHelper::normalizePath($file);
		return $file;
	}
	
}
