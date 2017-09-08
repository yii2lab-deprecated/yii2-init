<?php

namespace yii2lab\init\helpers;

class CopyFiles {

	static function copyAllFiles($root, $env, $overwrite)
	{
		$files = self::getFileList("$root/environments/{$env['path']}");
		$files = self::skipFiles($root, $env, $files);
		$all = false;
		foreach ($files as $file) {
			if (!self::copyFile($root, "environments/{$env['path']}/$file", $file, $all, $overwrite)) {
				break;
			}
		}
	}
	
	private static function getFileList($root, $basePath = '')
	{
		$files = [];
		$handle = opendir($root);
		while (($path = readdir($handle)) !== false) {
			if ($path === '.git' || $path === '.svn' || $path === '.' || $path === '..') {
				continue;
			}
			$fullPath = "$root/$path";
			$relativePath = $basePath === '' ? $path : "$basePath/$path";
			if (is_dir($fullPath)) {
				$files = array_merge($files, self::getFileList($fullPath, $relativePath));
			} else {
				$files[] = $relativePath;
			}
		}
		closedir($handle);
		return $files;
	}

	private static function skipFiles($root, $env, $files)
	{
		if (isset($env['skipFiles'])) {
			$files = array_diff($files, $env['skipFiles']);
		}
		return $files;
	}
	
	private static function copyFile($root, $source, $target, &$all, $overwrite)
	{
		if (!is_file($root . '/' . $source)) {
			echo "       skip $target ($source not exist)\n";
			return true;
		}
		if (is_file($root . '/' . $target)) {
			if (file_get_contents($root . '/' . $source) === file_get_contents($root . '/' . $target)) {
				echo "  unchanged $target\n";
				return true;
			}
			if ($all) {
				echo "  overwrite $target\n";
			} else {
				echo "      exist $target\n";
				echo "            ...overwrite? [Yes|No|All|Quit] ";
				$answer = !empty($overwrite) ? $overwrite : trim(fgets(STDIN));
				if (!strncasecmp($answer, 'q', 1)) {
					return false;
				} else {
					if (!strncasecmp($answer, 'y', 1)) {
						echo "  overwrite $target\n";
					} else {
						if (!strncasecmp($answer, 'a', 1)) {
							echo "  overwrite $target\n";
							$all = true;
						} else {
							echo "       skip $target\n";
							return true;
						}
					}
				}
			}
			file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source));
			return true;
		}
		echo "   generate $target\n";
		@mkdir(dirname($root . '/' . $target), 0777, true);
		file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source));
		return true;
	}

	
}
