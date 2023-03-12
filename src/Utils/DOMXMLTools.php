<?php

namespace SukWs\Bookshelf\Utils;

use DOMElement;
use DOMNode;
use DOMText;

class DOMXMLTools {
	
	public static function isEmpty (DOMNode $element, bool $allow_empty_text = true, bool $allow_cdata = false): bool {
		if ($element->nodeName == "#comment")
			return true;
		if ($allow_empty_text && $element->nodeName == "#text" && empty(trim($element->nodeValue)))
			return true;
		if ($allow_cdata && $element->nodeName == "#cdata" && empty(trim($element->nodeValue)))
			return true;
		return false;
	}
	
	public static function firstChild (DOMElement $element): ?DOMElement {
		$current = $element->firstChild;
		if ($current != null && self::isEmpty($current))
			self::next($current);
		return $current;
	}
	
	public static function next (DOMElement|DOMText &$current): void {
		do
			$current = $current->nextSibling;
		while ($current != null && self::isEmpty($current));
	}
	
}