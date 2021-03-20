<?php

class Segment {
	
	private string $id;
	private string $name;
	
	public function __construct ($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public static function parse (DOMNode $xmlData): Segment {
		$node = null;
		if ($xmlData->hasAttributes()) {
			$node = new Segment(
				$xmlData->attributes->getNamedItem("id")->nodeValue,
				$xmlData->attributes->getNamedItem("name")->nodeValue
			);
		}
		return $node;
	}
	
}