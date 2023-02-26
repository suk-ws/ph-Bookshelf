<?php

namespace SukWs\Bookshelf\Element\BookContent;

use DOMNode;
use Exception;

class Separator {
	
	private Chapter $parent;
	
	private function __construct (Chapter $parent) {
		$this->parent = $parent;
	}
	
	/**
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData, ?Chapter $parent): Separator {
		if ($xmlData->hasAttributes() || $xmlData->hasChildNodes())
			throw new Exception("Separator need be clean with no any attr/children");
		if ($parent->getParent() != null)
			throw new Exception("Separator must in root contents path");
		return new Separator($parent);
	}
	
	/**
	 * @return Chapter
	 */
	public function getParent (): Chapter {
		return $this->parent;
	}
	
	public function getSummaryHtml (): string {
		return "<hr/>";
	}
	
}