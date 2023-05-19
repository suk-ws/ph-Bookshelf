<?php

namespace SukWs\Bookshelf\Resource;

class Resource {
	
	public static function getRealRootPath (): string {
		return realpath("./");
	}
	
}
