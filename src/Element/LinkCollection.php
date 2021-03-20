<?php

require_once "./src/Element/Link.php";

class LinkCollection {
	
	/** @var Link[]|LinkCollection[] */
	private array $array;
	
	private function __construct (array $a) {
		$this->array = $a;
	}
	
	public static function parse (DOMNode $root): LinkCollection {
		$node = new LinkCollection(array());
		for ($child = $root->firstChild; $child != null; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Link":
					array_push($node->array, Link::parse($child));
					break;
				case "Collection":
					array_push($node->array, LinkCollection::parse($child));
					break;
				case "#text":
					break;
				default:
					echo "ERROR UNSUPPORTED NODE TYPE ON LINK COLLECTION\n";
			}
		}
		return $node;
	}
	
	/**
	 * @return Link[]|LinkCollection[]
	 */
	public function getCollection (): array {
		return $this->array;
	}
	
}
