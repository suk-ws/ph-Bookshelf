<?php

require_once "./src/Element/BookContent/Page.php";

class Chapter {
	
	private string $name;
	
	/** @var Chapter[]|Page[] */
	private array $childs;
	
	private ?Chapter $parent;
	
	private function __construct (string $name, array $array, ?Chapter $parent) {
		$this->name = $name;
		$this->childs = $array;
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @param ?Chapter $parent
	 * @return Chapter
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, ?Chapter $parent): Chapter {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			if ($attrName == null) throw new Exception("Chapter xml data missing attribute \"name\"");
			else $node = new Chapter($xmlData->attributes->getNamedItem("name")->nodeValue, array(), $parent);
		} else throw new Exception("Chapter xml data missing attributes");
		for ($child = $xmlData->firstChild;$child != null ; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Page":
					array_push($node->childs, Page::parse($child, $node));
					break;
				case "Chapter":
					array_push($node->childs, self::parse($child, $node));
					break;
				case "#text":
					break;
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
	public function getChilds (): array {
		return $this->childs;
	}
	
	/**
	 * @return Chapter|null
	 */
	public function getParent (): Chapter {
		return $this->parent;
	}
	
	public function getSummaryHtml (): string {
		$str = "";
		if ($this->parent != null) $str .= "<li class='chapter fold" . ($this->getPage(PageMeta::$page->getId())==null?"":" on") . "'><a class='page-chapter'>$this->name<i class='exc-trigger fa'></i></a><ul class='page-chapter summary'>";
		foreach ($this->childs as $node) {
			$str .= $node->getSummaryHtml();
		}
		if ($this->parent != null) $str .= "</ul></li>";
		return $str;
	}
	
	public function getPage (string $id): ?Page {
		
		foreach ($this->childs as $node) {
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
