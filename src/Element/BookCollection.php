<?php

namespace SukWs\Bookshelf\Element;

use SukWs\Bookshelf\Data\PageMeta;
use DOMNode;
use Exception;

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
	 * @param DOMNode $collectionNode
	 * @param ?BookCollection $parent
	 * @param bool $isRoot
	 * @return BookCollection
	 * @throws Exception
	 */
	public static function parse (DOMNode $collectionNode, ?BookCollection $parent, bool $isRoot = false): BookCollection {
		$collectionName = LinkCollection::ROOT;
		$child = $collectionNode->firstChild;
		if ($child == null) throw new Exception("an BookCollection is NULL!");
		if (!$isRoot) {
			while ($child->nodeName != "caption") {
				switch ($child->nodeName) {
					case "#comment":
						break;
					case "#text":
						if (empty(trim($child->nodeValue))) break;
					default:
						throw new Exception("BookCollection need a \"caption\" as first child but \"$child->nodeName\" found");
				}
				$child = $child->nextSibling;
			}
			$collectionName = $child->nodeValue;
			$child = $child->nextSibling;
		}
		$node = new BookCollection($collectionName, $parent);
		for (; $child != null; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Book":
					$node->array[] = Book::parse($child, $node);
					break;
				case "Collection":
					$node->array[] = BookCollection::parse($child, $node);
					break;
				case "#comment":
					break;
				case "#text":
					if (empty(trim($child->nodeValue))) break;
					throw new Exception("Unsupported element type \"$child->nodeName\" in BookCollection named \"$collectionName\"");
				default:
					throw new Exception("Unsupported element type \"$child->nodeName\" in BookCollection named \"$collectionName\"");
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
	public function getParent (): ?BookCollection {
		return $this->parent;
	}
	
	public function getHtml (int $indent = 0): string {
		$str = "";
		$isRoot = $this->name == self::ROOT;
		if (!$isRoot) $str .= sprintf(<<<EOL
			%s<div class='menu-item-parent%s'>
			%s<a class='no-style menu-item'>%s</a>
			%s<div class='children'>
			EOL,
			str_repeat("\t", $indent), $this->getBook(PageMeta::$book->getId())==null?"":" active",
			str_repeat("\t", $indent), $this->name,
			str_repeat("\t", $indent)
		);
		$str .= "\n";
		foreach ($this->array as $node) {
			$str .= $node->getHtml($isRoot ? $indent : $indent + 2);
			$str .= "\n";
		}
		if (!$isRoot) $str .= str_repeat("\t", $indent) . "</div></div>";
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
