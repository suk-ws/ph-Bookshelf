<?php

namespace SukWs\Bookshelf\Utils;

use DOMDocument;
use DOMElement;
use DOMImplementation;

class DOMHtml {
	
	public static function createHtmlDocument (): DOMDocument {
		$dom = new DOMImplementation();
		return $dom->createDocument(null, 'html', $dom->createDocumentType('html'));
	}
	
	public static function createHeaderMeta (DOMDocument $root, array $metas): DOMElement {
		$element = $root->createElement("meta");
		foreach ($metas as $name => $value) {
			$element->setAttribute($name, $value);
		}
		return $element;
	}
	
	public static function createStylesheetRef (DOMDocument $root, string $href): DOMElement {
		$element = $root->createElement("link");
		$element->setAttribute("rel", "stylesheet");
		$element->setAttribute("href", $href);
		return $element;
	}
	
	public static function createScriptRef (DOMDocument $root, string $href): DOMElement {
		$element = $root->createElement("script");
		$element->setAttribute("src", $href);
		return $element;
	}
	
}