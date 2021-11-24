<?php

require_once "./src/Element/Link.php";

class LinkCollection {
	
	const ROOT = "%root";
	
	private string $name;
	
	/** @var Link[]|LinkCollection[] */
	private array $array;
	private ?LinkCollection $parent;
	
	private function __construct (string $name, ?LinkCollection $parent) {
		$this->name = $name;
		$this->array = array();
		$this->parent = $parent;
	}
	
	/**
	 * @param DOMNode $root
	 * @param ?LinkCollection $parent
	 * @param bool $isRoot
	 * @return LinkCollection
	 * @throws Exception
	 */
	public static function parse (DOMNode $root, ?LinkCollection $parent, bool $isRoot = false): LinkCollection {
		$name = LinkCollection::ROOT;
		if (!$isRoot) {
			if ($root->hasAttributes()) {
				$attrName = $root->attributes->getNamedItem("name");
				if ($attrName == null) throw new Exception("LinkCollection (not root) xml data missing attribute \"name\"");
				else $name = $attrName->nodeValue;
			} else throw new Exception("LinkCollection (not root) xml data missing attributes");
		}
		$node = new LinkCollection($name, $parent);
		for ($child = $root->firstChild; $child != null; $child = $child->nextSibling) {
			switch ($child->nodeName) {
				case "Link":
					array_push($node->array, Link::parse($child, $node));
					break;
				case "Collection":
					array_push($node->array, LinkCollection::parse($child, $node));
					break;
				case "#comment":
					break;
				case "#text":
					if (empty(trim($child->nodeValue))) break;
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
	
	/**
	 * @return LinkCollection|null
	 */
	public function getParent (): LinkCollection {
		return $this->parent;
	}
	
	public function getHtml (int $indent = 0): string {
		$str = "";
		$isRoot = $this->name == self::ROOT;
		if (!$isRoot) $str .= sprintf(<<<EOL
			%s<div class='menu-item-parent'>
			%s<a class='no-style menu-item' href='javascript:'>%s</a>
			%s<div class='children'>
			EOL,
			str_repeat("\t", $indent),
			str_repeat("\t", $indent), $this->name,
			str_repeat("\t", $indent)
		);
		$str .= "\n";
		foreach ($this->array as $node) {
			$str .= $node->getHtml($isRoot ? $indent : $indent + 2);
			$str .= "\n";
		}
		if (!$isRoot) $str .= str_repeat("\t", $indent) . "</div></div>";
		return $str;
	}
	
}
