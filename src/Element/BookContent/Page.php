<?php

require_once "./src/Data/PageMeta.php";
require_once "./src/Element/Bookshelf.php";
require_once "./src/Element/BookContent/Chapter.php";

class Page {
	
	private string $id;
	private string $name;
	
	private Chapter $parent;
	
	private array $configurations = array();
	
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
			Bookshelf::parseConfigurationAttr($xmlData->attributes, $node->configurations, array("name", "id"));
		} else
			throw new Exception("Book xml data missing attributes");
		for ($child = $xmlData->firstChild;$child != null ; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "#text":
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
	
	public function getConfiguration (string $key): ?string {
		return @$this->configurations[$key];
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
		return sprintf(<<<EOF
			<a id='page/%s' page-id='%s'
				class='no-style menu-item%s'
				href='%s'>%s</a>
			EOF,
			$this->id, $this->id,
			PageMeta::$page->getId()==$this->id ? " current" : "",
			PageMeta::$page->getId()==$this->id ? "#top" : $this->encodeUrl(),
			$this->name
		);
	}
	
	public function encodeUrl (): string {
		return str_replace(
			"%2F", "/",
			sprintf("/%s/%s", urlencode(PageMeta::$book->getId()), urlencode($this->id))
		);
	}
	
	public function getMarkdownContent (): string {
		return file_get_contents(sprintf("./data/%s/%s.md", PageMeta::$book->getId(), $this->id));
	}
	
}
