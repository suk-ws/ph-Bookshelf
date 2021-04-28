<?php

require_once "./src/Element/Book.php";

class BookCollection {
	
	const ROOT = "%root";
	
	private string $name;
	
	/** @var Book[]|BookCollection[] */
	private array $array;
	private ?BookCollection $parent;
	
	private function __construct (string $name, ?BookCollection $parent) {
		$this->name = $name;
		$this->array = array();
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $root
	 * @param ?BookCollection $parent
	 * @param bool $isRoot
	 * @return BookCollection
	 * @throws Exception
	 */
	public static function parse (DOMNode $root, ?BookCollection $parent, bool $isRoot = false): BookCollection {
		$name = BookCollection::ROOT;
		if (!$isRoot) {
			if ($root->hasAttributes()) {
				$attrName = $root->attributes->getNamedItem("name");
				if ($attrName == null) throw new Exception("BookCollection (not root) xml data missing attribute \"name\"");
				else $name = $attrName->nodeValue;
			} else throw new Exception("BookCollection (not root) xml data missing attributes");
		}
		$node = new BookCollection($name, $parent);
		for ($child = $root->firstChild; $child != null; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Book":
					array_push($node->array, Book::parse($child, $node));
					break;
				case "Collection":
					array_push($node->array, BookCollection::parse($child, $node));
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
	
	/**
	 * @return BookCollection|null
	 */
	public function getParent (): BookCollection {
		return $this->parent;
	}
	
	public function getHtml (): string {
		$str = "";
		if ($this->name != self::ROOT) $str .= "<li class='book-collection fold" . ($this->getBook(PageMeta::$book->getId())==null?"":"on") . "'><a class='book-collection' href='#'>$this->name<i class='exc-trigger fa'></i></a><ul class='book-collection summary'>";
		foreach ($this->array as $node) {
			$str .= $node->getHtml();
		}
		if ($this->name != self::ROOT) $str .= "</ul></li>";
		return $str;
	}
	
	public function getBook (string $id): ?Book {
		
		foreach ($this->array as $node) {
			if ($node instanceof Book && $node->getId() == $id)
				return $node;
			else if ($node instanceof BookCollection) {
				$got = $node->getBook($id);
				if ($got != null) return $got;
			}
		}
		
		return null;
		
	}
	
}
