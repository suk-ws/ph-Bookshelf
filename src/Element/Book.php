<?php

namespace SukWs\Bookshelf\Element;

use SukWs\Bookshelf\Data\PageMeta;
use DOMNode;
use SukWs\Bookshelf\Element\BookContent\BookContented;
use Exception;

class Book {
	
	private string $id;
	private string $name;
	private BookCollection $parent;
	
	public function __construct (string $id, string $name, BookCollection $parent) {
		$this->id = $id;
		$this->name = $name;
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $bookNode
	 * @param BookCollection $parent
	 * @return Book
	 * @throws Exception
	 */
	public static function parse (DOMNode $bookNode, BookCollection $parent): Book {
		if ($bookNode->hasAttributes()) {
			$attrId = $bookNode->attributes->getNamedItem("id");
			if ($attrId == null) throw new Exception("an Book xml data named missing attribute \"id\"");
			else $id = $attrId->nodeValue;
		} else
			throw new Exception("Book xml data missing attributes");
		$valueName = $bookNode->nodeValue;
//		if ($bookNode->hasChildNodes()) {
//			for ($child = $bookNode->firstChild; $child; $child = $child->nextSibling) {
//				$valueName .= match ($child->nodeName) {
//					"#text", "#cdata-section" => $child->nodeValue,
//					default => throw new Exception("Unsupported element type \"$child->nodeName\" in parsing configuration $bookNode->nodeName")
//				};
//			}
//		} // todo warn if no link name
		return new Book($id, $valueName, $parent);
	}
	
	public function getId (): string {
		return $this->id;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	/**
	 * @return BookCollection|null
	 */
	public function getParent (): ?BookCollection {
		return $this->parent;
	}
	
	public function getHtml (int $indent = 0): string {
		return sprintf(<<<EOF
			%s<a id='book/%s' book-id='%s'
			%s  class='no-style menu-item%s'
			%s  href='%s'" . ">%s</a>
			EOF,
			str_repeat("\t", $indent), $this->id, $this->id,
			str_repeat("\t", $indent), PageMeta::$book->getId()==$this->id ? " current" : "",
			str_repeat("\t", $indent), PageMeta::$book->getId()==$this->id ? "javascript:void(0)" : $this->encodeUrl(), $this->name
		);
	}
	
	public function encodeUrl (): string {
		return "/" . urlencode($this->id);
	}
	
	/**
	 * @throws Exception
	 */
	public function getContentedNode (): BookContented {
		return BookContented::parseString(file_get_contents("./data/$this->id/book.xml"));
	}
	
}
