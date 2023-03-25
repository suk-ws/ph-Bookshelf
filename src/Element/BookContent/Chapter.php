<?php

namespace SukWs\Bookshelf\Element\BookContent;

use SukWs\Bookshelf\Data\PageMeta;
use DOMNode;
use Exception;

class Chapter {
	
	private string $name;
	
	/** @var Chapter[]|Page[] */
	private array $children;
	
	private ?Chapter $parent;
	
	private function __construct (string $name, array $array, ?Chapter $parent) {
		$this->name = $name;
		$this->children = $array;
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @param ?Chapter $parent
	 * @return Chapter
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, ?Chapter $parent, ?string $idRoot = null): Chapter {
		$child = $xmlData->firstChild;
		if ($parent != null) {
			while ($child->nodeName != "caption") {
				switch ($child->nodeName) {
					case "#comment":
						break;
					case "#text":
						if (empty(trim($child->nodeValue))) break;
					default:
						throw new Exception("Chapter need a \"caption\" as first child but \"$child->nodeName\" found");
				}
				$child = $child->nextSibling;
			}
			$node = new Chapter($child->nodeValue, array(), $parent);
			$child = $child->nextSibling;
		} else $node = new Chapter("", array(), $parent);
		$attrRoot = $xmlData->attributes->getNamedItem("root");
		$chapterIdRoot = $idRoot . $attrRoot?->nodeValue;
		for (;$child != null ; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Page":
					$node->children[] = Page::parse($child, $node, $chapterIdRoot);
					break;
				case "Chapter":
					$node->children[] = self::parse($child, $node, $chapterIdRoot);
					break;
				case "Separator":
					$node->children[] = Separator::parse($child, $node);
					break;
				case "#comment":
					break;
				case "#text":
					if (empty(trim($child->nodeValue))) break;
					throw new Exception("Unsupported element type \"$child->nodeName\" in Chapter \"$node->name\"");
				default:
					throw new Exception("Unsupported element type \"$child->nodeName\" in Chapter \"$node->name\"");
			}
		}
		return $node;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	/**
	 * @return Chapter[]|Page[]
	 */
	public function getChildren (): array {
		return $this->children;
	}
	
	/**
	 * @return Chapter|null
	 */
	public function getParent (): ?Chapter {
		return $this->parent;
	}
	
	public function getSummaryHtml (): string {
		$str = "";
		if ($this->parent != null) $str .= sprintf(<<<EOL
			<div class='menu-item-parent%s'>
				<a class='no-style menu-item' href='javascript:'>%s</a>
				<div class='children'>
			EOL,
			$this->getPage(PageMeta::$page_id)==null?"":" active",
			$this->name
		);
		foreach ($this->children as $node) {
			$str .= $node->getSummaryHtml();
		}
		if ($this->parent != null) $str .= "</div></div>";
		return $str;
	}
	
	public function getPage (string $id): ?Page {
		
		foreach ($this->children as $node) {
			if ($node instanceof Page && $node->getId() == $id)
				return $node;
			else if ($node instanceof Chapter) {
				$got = $node->getPage($id);
				if ($got != null) return $got;
			}
		}
		
		return null;
		
	}
	
}
