<?php

require_once "./src/Element/BookContent/Segment.php";

class Page {
	
	private string $id;
	private string $name;
	
	/** @var Segment[] */
	private array $segues;
	
	public function __construct (string $id, string $name, array $childs = array()) {
		$this->id = $id;
		$this->name = $name;
		$this->segues = $childs;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @return Page
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData): Page {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrId = $xmlData->attributes->getNamedItem("id");
			if ($attrName == null)
				if ($attrId == null) throw new Exception("Page xml data missing attribute \"name\"");
				else throw new Exception("Page xml data with id \"$attrId->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrId == null) throw new Exception("Page xml data named \"$name\" missing attribute \"id\"");
			else $id = $attrId->nodeValue;
			$node = new Page($id, $name);
		} else
			throw new Exception("Book xml data missing attributes");
		for ($child = $xmlData->firstChild;$child != null ; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Segment":
					array_push($node->segues, Segment::parse($child));
					break;
				case "#text":
					break;
				default:
					throw new Exception("Unsupported element type \"$child->nodeName\" in Page with id $id");
			}
		}
		return $node;
	}
	
	public function getId (): string {
		return $this->id;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	/**
	 * @return Segment[]
	 */
	public function getSegments (): array {
		return $this->segues;
	}
	
}
