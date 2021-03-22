<?php

require_once "./src/Element/Book.php";

class BookCollection {
	
	const ROOT = "%root";
	
	private string $name;
	
	/** @var Book[]|BookCollection[] */
	private array $array;
	
	private function __construct (string $name, array $a) {
		$this->name = $name;
		$this->array = $a;
	}
	
	/**
	 * @param DOMNode $root
	 * @param bool $isRoot
	 * @return BookCollection
	 * @throws Exception
	 */
	public static function parse (DOMNode $root, bool $isRoot = false): BookCollection {
		$name = BookCollection::ROOT;
		if (!$isRoot) {
			if ($root->hasAttributes()) {
				$attrName = $root->attributes->getNamedItem("name");
				if ($attrName == null) throw new Exception("BookCollection (not root) xml data missing attribute \"name\"");
				else $name = $attrName->nodeValue;
			} else throw new Exception("BookCollection (not root) xml data missing attributes");
		}
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
					throw new Exception("Unsupported element type \"$child->nodeName\" in BookCollection named \"$name\"");
			}
		}
		return $node;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	/**
	 * @return Book[]|BookCollection[]
	 */
	public function getCollection (): array {
		return $this->array;
	}
	
}
