<?php

namespace SukWs\Bookshelf\Utils;

use Nette\Utils\Random;

class Resources {
	
	public static function webResPath(string $type, string $id, string $version = null): string {
		$version = ON_DEVELOPMENT ? null : $version;
		$version = $version == null ? Random::generate() : $version;
		return "/assets/web/$id.$type?v=" . $version;
	}
	
}