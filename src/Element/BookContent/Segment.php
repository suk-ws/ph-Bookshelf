<?php

require_once "./src/Element/BookContent/Page.php";

class Segment {
	
	private string $id;
	private string $name;
	private Page $parent;
	
	public function __construct (string $id, string $name, Page $parent) {
		$this->id = $id;
		$this->name = $name;
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @param Page $parent
	 * @return Segment
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, Page $parent): Segment {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrId = $xmlData->attributes->getNamedItem("id");
			if ($attrName == null)
				if ($attrId == null) throw new Exception("Segment xml data missing attribute \"name\"");
				else throw new Exception("Segment xml data with id \"$attrId->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrId == null) throw new Exception("Segment xml data named \"$name\" missing attribute \"id\"");
			else $id = $attrId->nodeValue;
		} else
			throw new Exception("Segment xml data missing attributes");
		if ($xmlData->hasChildNodes())
			throw new Exception("Segment xml named \"$name\" have some children which are not supported");
		return new Segment($id, $name, $parent);
	}
	
	public function getId (): string {
		return $this->id;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	public function getParent (): Page {
		return $this->parent;
	}
	
	public function getSummaryHtml (): string {
		return "<li class='page-segment chapter'><a href='/" . (PageMeta::$page->getId()==$this->parent->getId()?"":PageMeta::$book->getId()."/".$this->parent->getId()."") . "#$this->id'>$this->name</a></li>";
	}
	
}