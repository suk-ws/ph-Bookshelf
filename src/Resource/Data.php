<?php

namespace SukWs\Bookshelf\Resource;

class Data {
	
	private const root = './data/';
	
	private readonly string $path;
	
	private function __construct ($path) {
		$this->path = $path;
	}
	
	public function get_content(): string {
		return file_get_contents($this->path);
	}
	
	public static function get(string $id): Data|false {
		$path = realpath(self::root.$id);
		if ($path !== false && self::checkSafety($path)) {
			return new Data($path);
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