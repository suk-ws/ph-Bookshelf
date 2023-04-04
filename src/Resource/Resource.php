<?php

namespace SukWs\Bookshelf\Resource;

class Resource {
	
	public static function getRealRootPath (): string {
		return realpath("./");
	}
	public static function checkSafety (string $checked): bool {
		return str_starts_with(realpath($checked), self::getRealRootPath());
	}
	
}
