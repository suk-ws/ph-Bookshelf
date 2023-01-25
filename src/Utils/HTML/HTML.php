<?php

namespace SukWs\Bookshelf\Utils\HTML;

use SukWs\Bookshelf\Utils\PageContentType;

class HTML implements PageContentType {
	
	public const type = array("html", "htm");
	
	public function type (): array {
		return self::type;
	}
	
	public function parse (string $raw): string {
		return $raw;
	}
	
}