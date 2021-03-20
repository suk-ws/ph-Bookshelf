<?php

require_once "./src/Element/Book.php";
require_once "./src/Element/BookContent/Chapter.php";

class BookContented extends Book {
	
	private Chapter $childs;
	
	public static function parse (DOMNode $xmlData): BookContented {
		if ($xmlData->hasAttributes() && $xmlData->hasChildNodes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrId = $xmlData->attributes->getNamedItem("id");
			if ($attrName == null)
				if ($attrId == null) throw new Exception("BookWithContent xml data missing attribute \"name\"");
				else throw new Exception("BookWithContent xml data with id \"$attrId->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrId == null) throw new Exception("BookWithContent xml data named \"$name\" missing attribute \"id\"");
			else $id = $attrId->nodeValue;
			$node = new BookContented($id, $name);
			$node->childs = Chapter::parse($xmlData);
		} else
			throw new Exception("No child or attribute found on BookWithContent");
		return $node;
	}
	
	/**
	 * @param string $xmlContent
	 * @return BookContented
	 * @throws Exception
	 */
	public static function parseString (string $xmlContent): BookContented {
		
		$dom = new DOMDocument();
		if ($dom->loadXML($xmlContent)) {
			return self::parse($dom->firstChild);
		} else throw new Exception("Load BookWithContent xml file failed");
		
	}
	
	public function getChilds (): Chapter {
		return $this->childs;
	}
	
}
