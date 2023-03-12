<?php

namespace SukWs\Bookshelf\Data\Bookshelf;

use DOMDocument;
use DOMElement;
use DOMNode;
use Exception;
use SukWs\Bookshelf\Utils\DOMXMLTools;
use SukWs\Bookshelf\Web\WebLog;

class NodeBookshelf {
	
	public readonly ?string $_Attr_version;
	
	public readonly string $_site_name;
	
	public array $_configurations;
	
	/**
	 * @throws Exception
	 */
	public function __construct(DOMElement $node_Bookshelf) {
		
		/* "" version "" */
		$this->_Attr_version = $node_Bookshelf->attributes->getNamedItem("version")?->nodeValue;
		// configure version check
		if ($this->_Attr_version == null) WebLog::warn("bookshelf.xml:: file version is not declared.\n - the current ph-bookshelf uses version 2.0");
		else if ($this->_Attr_version != "2.0") throw new Exception("-0I{@EI[AID"); // todo throw exception
		WebLog::info("bookshelf.xml:: read bookshelf.xml with config version ".$this->_Attr_version);
		
		/* @var DOMNode $dom_child */
		/* @var DOMElement $dom_child */$dom_child = DOMXMLTools::firstChild($node_Bookshelf);
		if ($dom_child == null) throw new Exception("bookshelf.xml:: is empty!");
		
		/* == site_name == */
		if (!$dom_child->nodeName == "site_name") throw new Exception("bookshelf.xml:: required <site_name> defined first but <".$dom_child->nodeName."> found."); // todo throw exception that site_name unavailable.
		$this->_site_name = $dom_child->nodeValue;
		DOMXMLTools::next($dom_child);
		WebLog::info("bookshelf.xml:: read site_name \"".$this->_site_name."\"");
		
		/* == configurations ==  */
		if ($dom_child->nodeName == "configurations") {
			$my_configurations = array();
			/* @var DOMElement $configNode */
			foreach ($dom_child->childNodes as $configNode) {
				if (DOMXMLTools::isEmpty($configNode)) continue;
				$my_configurations[$configNode->nodeName] = $configNode->nodeValue;
				WebLog::info("bookshelf.xml:: configuration:: read [".$configNode->nodeName."] = \"".$configNode->nodeValue."\"");
			}
			$this->_configurations = $my_configurations;
			DOMXMLTools::next($dom_child);
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