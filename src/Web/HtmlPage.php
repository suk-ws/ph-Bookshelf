<?php

namespace SukWs\Bookshelf\Web;

use DOMDocument;
use DOMElement;
use SukWs\Bookshelf\Utils\DOMHtml;
use SukWs\Bookshelf\Web\Html\Body;
use SukWs\Bookshelf\Web\Html\Head;

class HtmlPage {
	
	public DOMDocument $document;
	
	public WebResManager $res_manager;
	
	public DOMElement $_html_html;
	
	public Head $_html_head;
	public Body $_html_body;
	
	public function __construct() {
		
		/* == var == */
		/* @var */ $document = DOMHtml::createHtmlDocument();
		$this->document = $document;
		/* @var */ $dom_html = $document->documentElement;
		$this->_html_html = $dom_html;
		
		$this->res_manager = new WebResManager();
		
		/* @var */ $html_head = new Head($this);
		$this->_html_head = $html_head;
		/* @var */ $html_body = new Body($this);
		$this->_html_body = $html_body;
		
	}
	
	public function build(): self {
		$this->_html_html->appendChild($this->_html_head->build());
		$this->_html_html->appendChild($this->_html_body->build());
		return $this;
	}
	
}