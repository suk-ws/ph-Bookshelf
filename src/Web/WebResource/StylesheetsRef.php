<?php

namespace SukWs\Bookshelf\Web\WebResource;

use DOMDocument;
use DOMElement;
use SukWs\Bookshelf\Utils\DOMHtml;

class StylesheetsRef extends IWebResource {
	
	public string $uri;
	
	public function __construct(string $uri) {
		$this->uri = $uri;
	}
	
	public function build (DOMDocument $root): DOMElement {
		return DOMHtml::createStylesheetRef($root, $this->uri);
	}
	
}