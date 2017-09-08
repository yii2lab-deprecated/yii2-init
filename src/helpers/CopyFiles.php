<?php

namespace yii2lab\init\helpers;

use yii2lab\console\helpers\Output as ROutput;

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
			ROutput::line("       skip $target ($source not exist)");
			return true;
		}
		if (is_file($root . '/' . $target)) {
			if (file_get_contents($root . '/' . $source) === file_get_contents($root . '/' . $target)) {
				ROutput::line("  unchanged $target");
				return true;
			}
			if ($all) {
				ROutput::line("  overwrite $target");
			} else {
				ROutput::line("      exist $target");
				echo "            ...overwrite? [Yes|No|All|Quit] ";
				//ROutput::line();
				$answer = !empty($overwrite) ? $overwrite : trim(fgets(STDIN));
				if (!strncasecmp($answer, 'q', 1)) {
					return false;
				} else {
					if (!strncasecmp($answer, 'y', 1)) {
						ROutput::line("  overwrite $target");
					} else {
						if (!strncasecmp($answer, 'a', 1)) {
							ROutput::line("  overwrite $target");
							$all = true;
						} else {
							ROutput::line("       skip $target");
							return true;
						}
					}
				}
			}
			file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source));
			return true;
		}
		ROutput::line("   generate $target");
		@mkdir(dirname($root . '/' . $target), 0777, true);
		file_put_contents($root . '/' . $target, file_get_contents($root . '/' . $source));
		return true;
	}

	
}
