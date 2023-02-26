<?php

namespace SukWs\Bookshelf\Element;

use DOMNode;
use Exception;

class Link {
	
	private string $name;
	private string $href;
	private LinkCollection $parent;
	
	public function __construct (string $name, string $href, LinkCollection $parent) {
		$this->name = $name;
		$this->href = $href;
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $linkNode
	 * @param LinkCollection $parent
	 * @return Link
	 * @throws Exception
	 */
	public static function parse (DOMNode $linkNode, LinkCollection $parent): Link {
		if ($linkNode->hasAttributes()) {
			$attrHref = $linkNode->attributes->getNamedItem("href");
			if ($attrHref == null) throw new Exception("an Link data missing attribute \"href\"");
			else $href = $attrHref->nodeValue;
		} else
			throw new Exception("an Link data missing attributes");
		$valueName = $linkNode->nodeValue;
//		if ($linkNode->hasChildNodes()) {
//			for ($child = $linkNode->firstChild; $child; $child = $child->nextSibling) {
//				$valueName .= match ($child->nodeName) {
//					"#text", "#cdata-section" => $child->nodeValue,
//					default => throw new Exception("Unsupported element type \"$child->nodeName\" in parsing configuration $linkNode->nodeName")
//				};
//			}
//		} // todo warn if no link name
		return new Link($valueName, $href, $parent);
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	public function getHref (): string {
		return $this->href;
	}
	
	/**
	 * @return LinkCollection|null
	 */
	public function getParent (): ?LinkCollection {
		return $this->parent;
	}
	
	public function getHtml (int $indent = 0): string {
		return sprintf(
			"%s<a class='no-style menu-item' href='%s' target='_blank'>%s</a>",
			str_repeat("\t", $indent),
			$this->href, $this->name
		);
	}
	
}
