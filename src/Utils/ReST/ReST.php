<?php

namespace SukWs\Bookshelf\Utils\ReST;

use Gregwar\RST\Parser;
use SukWs\Bookshelf\Utils\PageContentType;

class ReST implements PageContentType {
	
	public const type = array("rst", "rest");
	
	/**
	 * @return string[]
	 */
	public function type (): array {
		return self::type;
	}
	
	public function parse (string $raw): string {
		return (new Parser())->parse($raw);
	}
	
}
