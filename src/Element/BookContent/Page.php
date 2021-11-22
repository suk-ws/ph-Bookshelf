<?php

require_once "./src/Data/PageMeta.php";
require_once "./src/Element/BookContent/Chapter.php";

class Page {
	
	private string $id;
	private string $name;
	
	private Chapter $parent;
	
	public function __construct (string $id, string $name, Chapter $parent) {
		$this->id = $id;
		$this->name = $name;
		$this->parent = $parent;
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
	
	public function getParent (): Chapter {
		return $this->parent;
	}
	
	public function getSummaryHtml (): string {
//		$str =
//			"<li id='page/$this->id' page-id='$this->id' class='page-contented chapter link-page " .
//			(PageMeta::$page->getId()==$this->id?" active":"") .
//			"'><a class='page-contented' " .
//			(
//				PageMeta::$page->getId()==$this->id ?
//				"" :
//				"href='/".PageMeta::$book->getId()."/".$this->id."' "
//			) .
//			">$this->name</a>";
//		if (sizeof($this->segues) > 0) {
//			$str .= "<ul class='page-contented summary'>";
//			foreach ($this->segues as $node) {
//				$str .= $node->getSummaryHtml();
//			}
//			$str .= "</ul>";
//		}
//		$str .= "</li>";
//		return $str;
		return "<a id='page/$this->id' page-id='$this->id' class='no-style menu-item" . (PageMeta::$page->getId()==$this->id?" current":"") . "' href='/".PageMeta::$book->getId()."/$this->id'" . ">$this->name</a>";
	}
	
	public function getMarkdownContent (): string {
		return file_get_contents("./data/".PageMeta::$book->getId()."/".$this->id.".md");
	}
	
}
