<?php

require_once "./src/Element/Book.php";
require_once "./src/Element/BookCollection.php";
require_once "./src/Element/Link.php";
require_once "./src/Element/LinkCollection.php";
require_once "./src/Element/BookContent/BookContented.php";

class Bookshelf {
	
	private string $siteName;
	
	private LinkCollection $links;
	private BookCollection $books;
	
	private BookContented $rootBook;
	
	public static function parseString (string $xmlData): Bookshelf {
		$return = new Bookshelf();
		$dom = new DOMDocument();
		if ($dom->loadXML($xmlData)) {
			$dom = $dom->firstChild;
			if ($dom->hasAttributes() && $dom->hasChildNodes()) {
				
				// Bookshelf 属性
				$return->siteName = $dom->attributes->getNamedItem("siteName")->nodeValue;
				
				// 对根节点的子节点进行遍历
				for ($rc = $dom->firstChild; $rc != null; $rc = $rc->nextSibling) {
					switch ($rc->nodeName) {
						case "links":
							$return->links = LinkCollection::parse($rc);
							break;
						case "books":
							$return->books = BookCollection::parse($rc);
							break;
						case "rootBook":
							$return->rootBook = BookContented::parse($rc);
							break;
						case "#text":
							break;
						default:
							echo "ERROR UNSUPPORTED TYPE ON BOOKSHELF\n";
					}
				}
				
			} else echo "ERROR ROOT NO CONTENT\n";
		} else echo "ERROR PARSE BOOKSHELF DOM FAILED\n";
		return $return;
	}
	
	public function getSiteName (): string {
		return $this->siteName;
	}
	
	/**
	 * @return LinkCollection
	 */
	public function getLinks (): LinkCollection {
		return $this->links;
	}
	
	/**
	 * @return BookCollection
	 */
	public function getBooks (): BookCollection {
		return $this->books;
	}
	
	public function getRootBook (): BookContented {
		return $this->rootBook;
	}
	
}
