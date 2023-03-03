<?php

namespace SukWs\Bookshelf\Web\WebResource;

use DOMDocument;
use DOMElement;

interface IWebResource {
	
	public function build (DOMDocument $root): DOMElement;
	
}