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
	
	public static function parse (DOMNode $xmlData): Page {
		$node = null;
		if (!$xmlData->hasAttributes()) {
			echo "ERROR PARSE XML PAGE NO ATTRIBUTE\n";
		} else {
			$node = new Page(
				$xmlData->attributes->getNamedItem("id")->nodeValue,
				$xmlData->attributes->getNamedItem("name")->nodeValue
			);
		}
		for ($child = $xmlData->firstChild;$child != null ; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Segment":
					array_push($node->segues, Segment::parse($child));
					break;
				case "#text":
					break;
				default:
					echo "ERROR UNSUPPORTED NODE TYPE ON PAGE CHAPTER\n";
			}
		}
		return $node;
	}
	
}
