<?php

namespace SukWs\Bookshelf\Utils;

interface PageContentType {
	
	/**
	 * @return string[]
	 */
	public function type (): array;
	
	public function parse (string $raw): string;
	
}
