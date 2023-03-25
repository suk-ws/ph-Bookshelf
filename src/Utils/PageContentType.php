<?php

namespace SukWs\Bookshelf\Utils;

use SukWs\Bookshelf\Data\PageData;

interface PageContentType {
	
	/**
	 * @return string[]
	 */
	public function type (): array;
	
	public function parse (string $raw): PageData;
	
}
