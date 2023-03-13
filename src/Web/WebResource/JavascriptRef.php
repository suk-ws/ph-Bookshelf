<?php

namespace SukWs\Bookshelf\Web\WebResource;

use DOMElement;
use DOMDocument;
use SukWs\Bookshelf\Utils\DOMHtml;

class JavascriptRef extends IWebResource {
	
	public string $uri;
	
	public function __construct(string $uri) {
		$this->uri = $uri;
	}
	
	public function build (DOMDocument $root): DOMElement {
		return DOMHtml::createScriptRef($root, $this->uri);
	}
	
}