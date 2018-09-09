<?php

namespace yii2lab\init\domain\helpers;

use yii2lab\extension\yii\helpers\FileHelper;

class Environments
{
	
	public static function update($name = 'dev')
	{
		$dir = ROOT_DIR . DS . 'environments' . DS . $name;
		$fileList = FileHelper::findFilesWithPath($dir);
		$map = [];
		foreach($fileList as $file) {
			$source = ROOT_DIR . DS . $file;
			$dest = $dir . DS . $file;
			if(!is_file($source)) {
				continue;
			}
			if(md5_file($source) != md5_file($dest)) {
				copy($source, $dest);
				$map[] = $file;
			}
		}
		return $map;
	}

	public static function delete($name = 'dev')
	{
		$dir = ROOT_DIR . DS . 'environments' . DS . $name;
		$fileList = FileHelper::findFilesWithPath($dir);
		
		$map = [];
		foreach($fileList as $file) {
			$source = ROOT_DIR . DS . $file;
			$dest = $dir . DS . $file;
			if(!is_file($source)) {
				continue;
			}
			if(is_file($dest)) {
				unlink($source);
				$map[] = $file;
			}
		}
		return $map;
	}

}
