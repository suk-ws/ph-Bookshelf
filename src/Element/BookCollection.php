<?php

require_once "./src/Element/Book.php";

class BookCollection {
	
	const ROOT = "::root";
	
	private string $name;
	
	/** @var Book[]|BookCollection[] */
	private array $array;
	
	private function __construct (string $name, array $a) {
		$this->name = $name;
		$this->array = $a;
	}
	
	public static function parse (DOMNode $root, bool $isRoot = false): BookCollection {
		$name = LinkCollection::ROOT;
		if (!$isRoot) $name = $root->attributes->getNamedItem("name")->nodeValue;
		$node = new BookCollection($name, array());
		for ($child = $root->firstChild; $child != null; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Book":
					array_push($node->array, Book::parse($child));
					break;
				case "Collection":
					array_push($node->array, BookCollection::parse($child));
					break;
				case "#text":
					break;
				default:
					echo "ERROR UNSUPPORTED NODE TYPE ON BOOK COLLECTION\n";
			}
		}
		return $node;
	}
	
	/**
	 * @return Book[]|BookCollection[]
	 */
	public function getCollection (): array {
		return $this->array;
	}
	
}
