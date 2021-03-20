<?php

class Book {
	
	private string $id;
	private string $name;
	
	public function __construct (string $id, string $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @return Book
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData): Book {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrId = $xmlData->attributes->getNamedItem("id");
			if ($attrName == null)
				if ($attrId == null) throw new Exception("Book xml data missing attribute \"name\"");
				else throw new Exception("Book xml data with id \"$attrId->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrId == null) throw new Exception("Book xml data named \"$name\" missing attribute \"id\"");
			else $id = $attrId->nodeValue;
		} else
			throw new Exception("Book xml data missing attributes");
		if ($xmlData->hasChildNodes())
			throw new Exception("Book xml with id \"$id\" have some children which are not supported");
		return new Book($id, $name);
	}
	
	public function getId (): string {
		return $this->id;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
}