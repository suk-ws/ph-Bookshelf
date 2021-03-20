<?php

class Link {
	
	private string $name;
	
	private string $href;
	
	public function __construct (string $name, string $href) {
		$this->name = $name;
		$this->href = $href;
	}
	
	public static function parse (DOMNode $xmlData): Link {
		$name = "";
		$href = "";
		if ($xmlData->hasAttributes()) {
			$name = $xmlData->attributes->getNamedItem("name")->nodeValue;
			$href = $xmlData->attributes->getNamedItem("href")->nodeValue;
		} else {
			echo "ERROR PARSE XML LINK NO ATTRIBUTE\n";
		}
		return new Link($name, $href);
	}
	
	public function getHref (): string {
		return $this->href;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
}
