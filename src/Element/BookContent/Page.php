<?php

namespace SukWs\Bookshelf\Element\BookContent;

use SukWs\Bookshelf\Data\PageMeta;
use DOMNode;
use SukWs\Bookshelf\Element\Bookshelf;
use Exception;

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
	 * @param DOMNode $pageNode
	 * @param Chapter $parent
	 * @return Page
	 * @throws Exception
	 */
	public static function parse (DOMNode $pageNode, Chapter $parent, ?string $idRoot): Page {
		if ($pageNode->hasAttributes()) {
			$attrId = $pageNode->attributes->getNamedItem("id");
			if ($attrId == null) throw new Exception("an Page xml data missing attribute \"id\"");
			else $id = $idRoot . $attrId->nodeValue;
		} else
			throw new Exception("Book xml data missing attributes");
		return new Page($id, $pageNode->nodeValue, $parent);
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
		return sprintf(<<<EOF
			<a id='page/%s' page-id='%s'
				class='no-style menu-item%s'
				href='%s'>%s</a>
			EOF,
			$this->id, $this->id,
			PageMeta::$page_id==$this->id ? " current" : "",
			PageMeta::$page_id==$this->id ? "#top" : $this->encodeUrl(),
			$this->name
		);
	}
	
	public function encodeUrl (): string {
		return str_replace(
			"%2F", "/",
			sprintf("/%s/%s", urlencode(PageMeta::$bookId), urlencode($this->id))
		);
	}
	
}
