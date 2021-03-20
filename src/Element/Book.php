<?php

class Book {
	
	private string $id;
	private string $name;
	
	public function __construct (string $id, string $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	public static function parse (DOMNode $xmlData): Book {
		$id = "";
		$name = "";
		if ($xmlData->hasAttributes()) {
			$id = $xmlData->attributes->getNamedItem("id")->nodeValue;
			$name = $xmlData->attributes->getNamedItem("name")->nodeValue;
		} else {
			echo "ERROR PARSE XML BOOK NO ATTRIBUTE\n";
		}
		return new Book($id, $name);
	}
	
	public function getId (): string {
		return $this->id;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
}