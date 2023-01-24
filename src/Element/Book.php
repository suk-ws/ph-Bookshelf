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
	 * @param DOMNode $xmlData
	 * @param BookCollection $parent
	 * @return Book
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, BookCollection $parent): Book {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrId = $xmlData->attributes->getNamedItem("id");
			if ($attrName == null)
				if ($attrId == null) throw new Exception("Book xml data missing attribute \"name\"");
				else throw new Exception("Book xml data with id \"$attrId->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrId == null) throw new Exception("Book xml data named \"$name\" missing attribute \"id\"");
			else $id = $attrId->nodeValue;
		} else
			throw new Exception("Book xml data missing attributes");
		if ($xmlData->hasChildNodes())
			throw new Exception("Book xml with id \"$id\" have some children which are not supported");
		return new Book($id, $name, $parent);
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
