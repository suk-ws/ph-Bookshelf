<?php

class Link {
	
	private string $name;
	
	private string $href;
	
	public function __construct (string $name, string $href) {
		$this->name = $name;
		$this->href = $href;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @return Link
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData): Link {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrHref = $xmlData->attributes->getNamedItem("href");
			if ($attrName == null)
				if ($attrHref == null) throw new Exception("Link xml data missing attribute \"name\"");
				else throw new Exception("Link xml data which href is \"$attrHref->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrHref == null) throw new Exception("Link xml data named \"$name\" missing attribute \"href\"");
			else $href = $attrHref->nodeValue;
		} else
			throw new Exception("Link xml data missing attributes");
		if ($xmlData->hasChildNodes())
			throw new Exception("Link xml named \"$name\" have some children which are not supported");
		return new Link($name, $href);
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	public function getHref (): string {
		return $this->href;
	}
	
}
