<?php

namespace SukWs\Bookshelf\Element;

use DOMDocument;
use DOMNamedNodeMap;
use DOMNode;
use SukWs\Bookshelf\Element\BookContent\BookContented;
use Exception;

class Bookshelf {
	
	private string $siteName;
	
	private LinkCollection $links;
	private BookCollection $books;
	
	private BookContented $rootBook;
	
	private array $configurations = array();
	
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
						case "configurations":
							self::parseConfiguration($rc, $return->configurations);
							break;
						case "#comment":
							break;
						case "#text":
							if (empty(trim($rc->nodeValue))) break;
							throw new Exception("Unsupported element type \"$rc->nodeName\" in root child of Bookshelf");
						default:
							throw new Exception("Unsupported element type \"$rc->nodeName\" in root child of Bookshelf");
					}
				}
				
			} else throw new Exception("No child or attribute found on Bookshelf");
		} else throw new Exception("Load Bookshelf xml file failed");
		return $return;
	}
	
	/**
	 * @throws Exception
	 */
	public static function parseConfiguration(DOMNode $dom, array &$configurations): void {
		for ($rc = $dom->firstChild; $rc != null; $rc = $rc->nextSibling) {
			if ($rc->nodeName == "#text") {
				if (!empty(trim($rc->nodeValue)))
					throw new Exception("Unsupported element type \"$rc->nodeName\" in parsing configurations");
				else continue;
			} else if ($rc->nodeName == "#comment") continue;
			$value = "";
			for ($rcc = $rc->firstChild; $rcc != null; $rcc = $rcc->nextSibling) {
				switch ($rcc->nodeName) {
					case "#text":
					case "#cdata-section":
						$value .= trim($rcc->nodeValue);
						break;
					case "#comment":
						break;
					default:
						throw new Exception("Unsupported element type \"$rcc->nodeName\" in parsing configuration $rcc->nodeName");
				}
			}
			$configurations[$rc->nodeName] = $value;
		}
	}
	
	public static function parseConfigurationAttr (DOMNamedNodeMap $attributes, array &$configurations, array $ignores = array()): void {
		foreach ($attributes as $attr) {
			if (in_array($attr->name, $ignores)) continue;
			$configurations[$attr->name] = $attr->value;
		}
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
	
	public function getBook (string $id): ?Book {
		return $this->books->getBook($id);
	}
	
	public function getConfiguration (string $key): ?string {
		return @$this->configurations[$key];
	}
	
}
