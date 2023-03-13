<?php

namespace SukWs\Bookshelf\Web\Html;

use DOMElement;
use SukWs\Bookshelf\Data\Bookshelf\NodeBookshelf;
use SukWs\Bookshelf\Utils\DOMHtml;
use SukWs\Bookshelf\Web\HtmlPage;
use SukWs\Bookshelf\Web\WebLog;

class Head {
	
	public readonly HtmlPage $root;
	
	public DOMElement $__self;
	
	public readonly array $standard_headers;
	
	public ?string $site_title = null;
	public ?string $page_title = null;
	public string $separator = " - ";
	
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
		$this->site_title = $_data_shelf->_site_name;
		WebLog::info("set html <title> site name as \"".$this->site_title."\"");
	}
	
	public function build_html_title (): string {
		if ($this->site_title == null) {
			WebLog::error("Header Title cannot be set for site-title is not set.");
			return "...";
		}
		$title = "";
		if ($this->page_title != null)
			$title .= $this->page_title . $this->separator;
		$title .= $this->site_title;
		return $title;
	}
	
	public function build (): DOMElement {
		
		foreach ($this->standard_headers as $meta)
			$this->__self->appendChild($meta);
		
		foreach ($this->root->res_manager->build_stylesheetsDOM($this->root->document) as $style)
			$this->__self->appendChild($style);
		foreach ($this->root->res_manager->build_javascriptPreloadsDOM($this->root->document) as $script)
			$this->__self->appendChild($script);
		
		$title_dom = $this->root->document->createElement('title');
		$title_dom->appendChild($this->root->document->createTextNode($this->build_html_title()));
		$this->__self->appendChild($title_dom);
		
		return $this->__self;
		
	}
	
}
