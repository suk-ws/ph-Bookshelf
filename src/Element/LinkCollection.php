<?php

require_once "./src/Element/Link.php";

class LinkCollection {
	
	const ROOT = "::root";
	
	private string $name;
	
	/** @var Link[]|LinkCollection[] */
	private array $array;
	
	private function __construct (string $name, array $a) {
		$this->name = $name;
		$this->array = $a;
	}
	
	public static function parse (DOMNode $root, bool $isRoot = false): LinkCollection {
		$name = LinkCollection::ROOT;
		if (!$isRoot) $name = $root->attributes->getNamedItem("name")->nodeValue;
		$node = new LinkCollection($name, array());
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
