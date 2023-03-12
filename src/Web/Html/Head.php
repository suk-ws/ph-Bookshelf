<?php

namespace SukWs\Bookshelf\Web\Html;

use DOMElement;
use SukWs\Bookshelf\Data\Bookshelf\NodeBookshelf;
use SukWs\Bookshelf\Utils\DOMHtml;
use SukWs\Bookshelf\Web\HtmlPage;

class Head {
	
	public readonly HtmlPage $root;
	
	public DOMElement $__self;
	
	public readonly array $standard_headers;
	
	public function __construct (HtmlPage $root) {
		
		$this->root = $root;
		
		$this->__self = $root->document->createElement("head");
		
		$this->standard_headers = array(
			DOMHtml::createHeaderMeta($root->document, array("charset" => "UTF-8")),
			DOMHtml::createHeaderMeta($root->document, array("content" => "text/html; charset=UTF-8", "http-equiv" => "Content-Type")),
			DOMHtml::createHeaderMeta($root->document, array("name" => "HandheldFriendly", "content" => "true")),
			DOMHtml::createHeaderMeta($root->document, array("name" => "viewport", "content" => "width=device-width, initial-scale=1")),
			DOMHtml::createHeaderMeta($root->document, array("name" => "apple-mobile-web-app-capable", "content" => "yes")),
			DOMHtml::createHeaderMeta($root->document, array("name" => "apple-mobile-web-app-status-bar-style", "content" => "black")),
			DOMHtml::createHeaderMeta($root->document, array("name" => "generator", "content" => "ph-Bookshelf ".VERSION))
		);
		
	}
	
	public function _parseBookshelf (NodeBookshelf $_data_shelf): void {
		// todo use shelf config
	}
	
	public function build (): DOMElement {
		
		foreach ($this->standard_headers as $meta)
			$this->__self->appendChild($meta);
		
		// todo maybe css js manager?
		foreach ($this->root->res_manager->getStylesheetsDOM($this->root->document) as $style)
			$this->__self->appendChild($style);
		foreach ($this->root->res_manager->getJavascriptPreloadsDOM($this->root->document) as $script)
			$this->__self->appendChild($script);
		
		return $this->__self;
		
	}
	
}
