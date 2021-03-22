<?php

require_once "./src/Element/Link.php";

class LinkCollection {
	
	const ROOT = "%root";
	
	private string $name;
	
	/** @var Link[]|LinkCollection[] */
	private array $array;
	
	private function __construct (string $name, array $a) {
		$this->name = $name;
		$this->array = $a;
	}
	
	/**
	 * @param DOMNode $root
	 * @param bool $isRoot
	 * @return LinkCollection
	 * @throws Exception
	 */
	public static function parse (DOMNode $root, bool $isRoot = false): LinkCollection {
		$name = LinkCollection::ROOT;
		if (!$isRoot) {
			if ($root->hasAttributes()) {
				$attrName = $root->attributes->getNamedItem("name");
				if ($attrName == null) throw new Exception("LinkCollection (not root) xml data missing attribute \"name\"");
				else $name = $attrName->nodeValue;
			} else throw new Exception("LinkCollection (not root) xml data missing attributes");
		}
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
					throw new Exception("Unsupported element type \"$child->nodeName\" in LinkCollection named \"$name\"");
			}
		}
		return $node;
	}
	
	public function getName (): string {
		return $this->name;
	}
	
	/**
	 * @return Link[]|LinkCollection[]
	 */
	public function getCollection (): array {
		return $this->array;
	}
	
}
