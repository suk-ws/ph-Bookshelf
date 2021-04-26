<?php

require_once "./src/Element/BookContent/Chapter.php";
require_once "./src/Element/BookContent/Segment.php";

class Page {
	
	private string $id;
	private string $name;
	
	/** @var Segment[] */
	private array $segues;
	private Chapter $parent;
	
	public function __construct (string $id, string $name, Chapter $parent, array $childs = array()) {
		$this->id = $id;
		$this->name = $name;
		$this->parent = $parent;
		$this->segues = $childs;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @param Chapter $parent
	 * @return Page
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, Chapter $parent): Page {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrId = $xmlData->attributes->getNamedItem("id");
			if ($attrName == null)
				if ($attrId == null) throw new Exception("Page xml data missing attribute \"name\"");
				else throw new Exception("Page xml data with id \"$attrId->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrId == null) throw new Exception("Page xml data named \"$name\" missing attribute \"id\"");
			else $id = $attrId->nodeValue;
			$node = new Page($id, $name, $parent);
		} else
			throw new Exception("Book xml data missing attributes");
		for ($child = $xmlData->firstChild;$child != null ; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Segment":
					array_push($node->segues, Segment::parse($child, $node));
					break;
				case "#text":
					break;
				default:
					throw new Exception("Unsupported element type \"$child->nodeName\" in Page with id $id");
			}
		}
		return $node;
	}
	
	public function getId (): string {
		return $this->id;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	/**
	 * @return Segment[]
	 */
	public function getSegments (): array {
		return $this->segues;
	}
	
	public function getParent (): Chapter {
		return $this->parent;
	}
	
	public function getSummaryHtml (): string {
		$str = "<li class='page-contented chapter" . (PageMeta::$page->getId()==$this->id?" active":"") . "'><a class='page-contented' href='/" . (PageMeta::$page->getId()==$this->id?"#":(PageMeta::$book->getId()."/".$this->id)) . "'>$this->name</a>";
		if (sizeof($this->segues) > 0) {
			$str .= "<ul class='page-contented summary'>";
			foreach ($this->segues as $node) {
				$str .= $node->getSummaryHtml();
			}
			$str .= "</ul>";
		}
		$str .= "</li>";
		return $str;
	}
	
}
