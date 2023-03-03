<?php

namespace SukWs\Bookshelf\Utils;

use DOMElement;

class DOMXMLTools {
	
	public static function isEmpty (DOMElement $element, bool $allow_empty_text = true, bool $allow_cdata = false): bool {
		if ($element->nodeName == "#comment")
			return true;
		if ($allow_empty_text && $element->nodeName == "#text" && empty(trim($element->nodeValue)))
			return true;
		if ($allow_cdata && $element->nodeName == "#cdata" && empty(trim($element->nodeValue)))
			return true;
		return false;
	}
	
}