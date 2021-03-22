<?php

require_once "./src/Element/BookCollection.php";
require_once "./src/Element/LinkCollection.php";
require_once "./src/Element/BookContent/BookContented.php";

class Bookshelf {
	
	private string $siteName;
	
	private LinkCollection $links;
	private BookCollection $books;
	
	private BookContented $rootBook;
	
	/**
	 * @param string $xmlData
	 * @return Bookshelf
	 * @throws Exception
	 */
	public static function parseString (string $xmlData): Bookshelf {
		$return = new Bookshelf();
		$dom = new DOMDocument();
		if ($dom->loadXML($xmlData)) {
			$dom = $dom->firstChild;
			if ($dom->hasAttributes() && $dom->hasChildNodes()) {
				
				// Bookshelf 属性
				$attrSiteName = $dom->attributes->getNamedItem("siteName");
				if ($attrSiteName == null) throw new Exception("Bookshelf xml data missing attribute \"siteName\"");
				$return->siteName = $attrSiteName->nodeValue;
				
				// 对根节点的子节点进行遍历
				for ($rc = $dom->firstChild; $rc != null; $rc = $rc->nextSibling) {
					switch ($rc->nodeName) {
						case "links":
							$return->links = LinkCollection::parse($rc, null, true);
							break;
						case "books":
							$return->books = BookCollection::parse($rc, null, true);
							break;
						case "rootBook":
							$return->rootBook = BookContented::parse($rc);
							break;
						case "#text":
							break;
						default:
							throw new Exception("Unsupported element type \"$rc->nodeName\" in root child of Bookshelf");
					}
				}
				
			} else throw new Exception("No child or attribute found on Bookshelf");
		} else throw new Exception("Load Bookshelf xml file failed");
		return $return;
	}
	
	public function getSiteName (): string {
		return $this->siteName;
	}
	
	public function getLinks (): LinkCollection {
		return $this->links;
	}
	
	public function getBooks (): BookCollection {
		return $this->books;
	}
	
	public function getRootBook (): BookContented {
		return $this->rootBook;
	}
	
}
