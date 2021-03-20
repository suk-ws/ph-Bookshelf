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
	
	public static function parse (DOMNode $xmlData): Chapter {
		$node = new Chapter($xmlData->attributes->getNamedItem("name")->nodeValue, array());
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
					echo "ERROR UNSUPPORTED NODE TYPE ON BOOK CHAPTER\n";
			}
		}
		return $node;
	}
	
}
