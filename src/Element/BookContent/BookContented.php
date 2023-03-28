<?php

namespace SukWs\Bookshelf\Element\BookContent;

use DOMDocument;
use DOMNode;
use Exception;
use SukWs\Bookshelf\Element\Bookshelf;

class BookContented {
	
	private string $configVersion;
	
	private string $name;
	
	private array $configurations = array();
	
	public function __construct (string $configVersion) {
		$this->configVersion = $configVersion;
	}
	
	private Chapter $children;
	
	/**
	 * @param DOMNode $nodeBook
	 * @return BookContented
	 * @throws Exception
	 */
	public static function parse (DOMNode $nodeBook): BookContented {
		$attrVersion = $nodeBook->attributes->getNamedItem("version");
		$bookConfigVersion = $attrVersion?->nodeValue;
		$return = new BookContented($bookConfigVersion);
		for ($child = $nodeBook->firstChild; $child != null; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "book_name":
					if (!empty($return->name)) throw new Exception("Duplicated book_name in Book.xml");
					$return->name = $child->nodeValue;
					break;
				case "contents":
					if (!empty($return->children)) throw new Exception("Duplicated contents in Book.xml");
					$return->children = Chapter::parse($child, null);
					break;
				case "configurations":
					if (!empty($return->children)) throw new Exception("Duplicated configurations in Book.xml");
					Bookshelf::parseConfiguration($child, $return->configurations);
					break;
				case "#comment":
				case "#text":
					if (empty(trim($child->nodeValue))) break;
				default:
					throw new Exception("Book.xml has sub-node \"$child->nodeName\" with is not supported.");
			}
		}
		return $return;
	}
	
	/**
	 * @param DOMNode $rootBookNode
	 * @return BookContented
	 * @throws Exception
	 */
	public static function parseRootBook (DOMNode $rootBookNode, string $bookName): BookContented {
		$return = new BookContented("2.0");
		$return->name = $bookName;
		$return->children = Chapter::parse($rootBookNode, null);
		return $return;
	}
	
	/**
	 * @param string $xmlContent
	 * @return BookContented
	 * @throws Exception
	 */
	public static function parseString (string $xmlContent): BookContented {
		
		$dom = new DOMDocument();
		if ($dom->loadXML($xmlContent)) {
			return self::parse($dom->firstChild);
		} else throw new Exception("Load BookWithContent xml file failed");
		
	}
	
	public function getConfigVersion (): string {
		return $this->configVersion;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	public function getChildren (): Chapter {
		return $this->children;
	}
	
	public function getSummaryHtml (): string {
		return $this->children->getSummaryHtml();
	}
	
	public function getPage (string $id): ?Page {
		return $this->children->getPage($id);
	}
	
	public function getConfiguration (string $key): ?string {
		return @$this->configurations[$key];
	}
	
}
