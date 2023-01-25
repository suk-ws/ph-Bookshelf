<?php

namespace SukWs\Bookshelf\Utils\LaTeX;

use PhpLatex_Parser;
use PhpLatex_Renderer_Html;
use SukWs\Bookshelf\Utils\PageContentType;

class LaTeX implements PageContentType {
	
	public const type = array("tex");
	
	/**
	 * @return string[]
	 */
	public function type (): array {
		return self::type;
	}
	
	public function parse (string $raw): string {
		return (new PhpLatex_Renderer_Html())->render((new PhpLatex_Parser())->parse($raw));
	}
	
}