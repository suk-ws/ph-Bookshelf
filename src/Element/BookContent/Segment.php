<?php

class Segment {
	
	private string $id;
	private string $name;
	
	public function __construct ($id, $name) {
		$this->id = $id;
		$this->name = $name;
	}
	
	/**
	 * @param DOMNode $xmlData
	 * @return Segment
	 * @throws Exception
	 */
	public static function parse (DOMNode $xmlData): Segment {
		if ($xmlData->hasAttributes()) {
			$attrName = $xmlData->attributes->getNamedItem("name");
			$attrId = $xmlData->attributes->getNamedItem("id");
			if ($attrName == null)
				if ($attrId == null) throw new Exception("Segment xml data missing attribute \"name\"");
				else throw new Exception("Segment xml data with id \"$attrId->nodeValue\" missing attribute \"name\"");
			else $name = $attrName->nodeValue;
			if ($attrId == null) throw new Exception("Segment xml data named \"$name\" missing attribute \"id\"");
			else $id = $attrId->nodeValue;
		} else
			throw new Exception("Segment xml data missing attributes");
		if ($xmlData->hasChildNodes())
			throw new Exception("Segment xml named \"$name\" have some children which are not supported");
		return new Segment($id, $name);
	}
	
}