<?php

namespace SukWs\Bookshelf\Resource;

class Assets {
	
	private const root = './assets/';
	
	private readonly string $path;
	
	private function __construct ($path) {
		$this->path = $path;
	}
	
	public function get_content(): string|false {
		return file_get_contents($this->path);
	}
	
	public static function get(string $id): Assets|false {
		$path = realpath(self::root.$id);
		if ($path !== false && self::checkSafety($path)) {
			return new Assets($path);
		}
		return false;
	}
	
	private static function getRealRootPath(): string {
		return realpath(self::root);
	}
	
	private static function checkSafety (string $checked): bool {
		return str_starts_with(realpath($checked), self::getRealRootPath());
	}
	
}