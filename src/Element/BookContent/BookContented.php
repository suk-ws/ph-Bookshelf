<?php

require_once "./src/Element/Book.php";
require_once "./src/Element/BookContent/Chapter.php";

class BookContented extends Book {
	
	private Chapter $childs;
	
	public static function parse (DOMNode $xmlData): BookContented {
		$id = "";
		$name = "";
		if ($xmlData->hasAttributes()) {
			$id = $xmlData->attributes->getNamedItem("id")->nodeValue;
			$name = $xmlData->attributes->getNamedItem("name")->nodeValue;
		} else {
			echo "ERROR PARSE XML BOOK WITH CONTENT NO ATTRIBUTE\n";
		}
		$node = new BookContented($id, $name);
		if ($xmlData->hasChildNodes()) {
			$node->childs = Chapter::parse($xmlData);
		} else {
			echo "ERROR PARSE XML BOOK WITH CONTENT NO CHILD\n";
		}
		return $node;
	}
	
	public static function parseString (string $xmlContent): BookContented {
		
		$node = null;
		$dom = new DOMDocument();
		if ($dom->loadXML($xmlContent)) {
			$node = self::parse($dom->firstChild);
		} else echo "ERROR PARSE BOOK CONTENTED DOM FAILED\n";
		return $node;
		
	}
	
}
