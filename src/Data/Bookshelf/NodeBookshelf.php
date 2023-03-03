<?php

namespace SukWs\Bookshelf\Data\Bookshelf;

use DOMDocument;
use DOMElement;
use DOMNode;
use Exception;
use SukWs\Bookshelf\Utils\DOMXMLTools;
use SukWs\Bookshelf\Web\WebWarn;

class NodeBookshelf {
	
	public readonly ?string $_Attr_version;
	
	public readonly string $_site_name;
	
	public readonly array $_configurations;
	
	/**
	 * @throws Exception
	 */
	public function __construct(DOMElement $node_Bookshelf) {
		
		/* "" version "" */
		$this->_Attr_version = $node_Bookshelf->attributes->getNamedItem("version")?->nodeValue;
		// configure version check
		if ($this->_Attr_version == null) WebWarn::output("bookshelf.xml:: file version is not declared.\n - the current ph-bookshelf uses version 2.0");
		else if ($this->_Attr_version != "2.0") throw new Exception("-0I{@EI[AID"); // todo throw exception
		
		/* @var DOMNode $dom_child */
		$dom_child = $node_Bookshelf->firstChild;
		
		/* == site_name == */
		if (!$dom_child->nodeName == "site_name") throw new Exception("O*R*OIArlAIWR"); // todo throw exception that site_name unavailable.
		$this->_site_name = $dom_child->nodeValue;
		$dom_child = $dom_child->nextSibling;
		
		/* == configurations ==  */
		if ($dom_child->nodeName == "configurations") {
			$my_configurations = array();
			/* @var DOMElement $configNode */
			foreach ($dom_child->childNodes as $configNode) {
				if (DOMXMLTools::isEmpty($configNode)) continue;
				$my_configurations[$configNode->nodeName] = $configNode->nodeValue;
			}
			$this->_configurations = $my_configurations;
			$dom_child = $dom_child->nextSibling;
		}
		
		// todo elements.
		
	}
	
	/**
	 * @throws Exception
	 */
	public static function __load_from_xml(string $xml_string): NodeBookshelf {
		$dom_tree = new DOMDocument();
		$dom_tree->loadXML($xml_string); // todo if load failed
		$dom = $dom_tree->firstChild;
		if ($dom instanceof DOMElement)
			return new nodeBookshelf($dom);
		throw new Exception("*@YUpoAWUIDP"); // todo if no root element
	}
	
}