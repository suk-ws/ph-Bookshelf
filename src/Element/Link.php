<?php

require_once "./src/Element/LinkCollection.php";

class Link {
	
	private string $name;
	private string $href;
	private LinkCollection $parent;
	
	public function __construct (string $name, string $href, LinkCollection $parent) {
		$this->name = $name;
		$this->href = $href;
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @param LinkCollection $parent
	 * @return Link
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, LinkCollection $parent): Link {
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
		return new Link($name, $href, $parent);
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	public function getHref (): string {
		return $this->href;
	}
	
	/**
	 * @return LinkCollection|null
	 */
	public function getParent (): LinkCollection {
		return $this->parent;
	}
	
	public function getHtml (): string {
		return "<a class='no-style menu-item' href='$this->href' target='_blank'>$this->name</a>";
	}
	
}
