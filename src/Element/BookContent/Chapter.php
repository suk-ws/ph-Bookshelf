<?php

require_once "./src/Element/BookContent/Page.php";

class Chapter {
	
	private string $name;
	
	/** @var Chapter[]|Page[] */
	private array $childs;
	
	private function __construct (string $name, array $array) {
		$this->name = $name;
		$this->childs = $array;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @return Chapter
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData): Chapter {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			if ($attrName == null) throw new Exception("Chapter xml data missing attribute \"name\"");
			else $node = new Chapter($xmlData->attributes->getNamedItem("name")->nodeValue, array());
		} else throw new Exception("Chapter xml data missing attributes");
		for ($child = $xmlData->firstChild;$child != null ; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Page":
					array_push($node->childs, Page::parse($child));
					break;
				case "Chapter":
					array_push($node->childs, self::parse($child));
					break;
				case "#text":
					break;
				default:
					throw new Exception("Unsupported element type \"$child->nodeName\" in Chapter \"$node->name\"");
			}
		}
		return $node;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	/**
	 * @return Chapter[]|Page[]
	 */
	public function getChilds (): array {
		return $this->childs;
	}
	
}
