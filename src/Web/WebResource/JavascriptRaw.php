<?php

namespace SukWs\Bookshelf\Web\WebResource;

use DOMDocument;
use DOMElement;

class JavascriptRaw implements IWebResource {
	
	public string $javascript_raw_code;
	
	public function __construct (string $code) {
		$this->javascript_raw_code = $code;
	}
	
	public function build (DOMDocument $root): DOMElement {
		$dom = $root->createElement('script');
		$dom_value = $root->createTextNode($this->javascript_raw_code);
		$dom->appendChild($dom_value);
		return $dom;
	}
	
}
