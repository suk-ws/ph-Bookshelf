<?php

namespace SukWs\Bookshelf\Element\BookContent;

use DOMNode;
use Exception;

class Title {
	
	private Chapter $parent;
	private string $title;
	
	private function __construct (Chapter $parent, string $title) {
		$this->parent = $parent;
		$this->title = $title;
	}
	
	/**
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, ?Chapter $parent): Title {
		if ($xmlData->hasAttributes())
			throw new Exception("Title need be clean with no any attr/children");
		if ($parent->getParent() != null)
			throw new Exception("Title must in root contents path");
		return new Title($parent, $xmlData->nodeValue);
	}
	
	public function getParent (): Chapter {
		return $this->parent;
	}
	
	public function getSummaryHtml (): string {
		return "<p class='menu-title'>$this->title</p>";
	}
	
}