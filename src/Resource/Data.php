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
		if ($path !== false) {
			return new Data($path);
		}
		return false;
	}
	
}