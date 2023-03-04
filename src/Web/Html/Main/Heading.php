<?php

namespace SukWs\Bookshelf\Web\Html\Main;

use DOMElement;
use SukWs\Bookshelf\Web\HtmlPage;

class Heading {
	
	public HtmlPage $root;
	public MainContainer $parent;
	
	public DOMElement $__self;
	
	public DOMElement $_page_tools;
	public DOMElement $_page_tools_sidebar_toggle;
	
	public function __construct (MainContainer $parent) {
		
		$this->parent = $parent;
		$this->root = $parent->root;
		
		$this->__self = $this->root->document->createElement('div');
		$this->__self->setAttribute('id', 'main-heading');
		
		$this->_page_tools = $this->root->document->createElement('div');
		$this->_page_tools->setAttribute('id', 'page-tools');
		
		$this->_page_tools_sidebar_toggle = $this->root->document->createElement('button', "☰");
		$this->_page_tools_sidebar_toggle->setAttribute('id', 'sidebar-show');
		
	}
	
	public function build (): DOMElement {
		$this->_page_tools->appendChild($this->_page_tools_sidebar_toggle);
		$this->__self->appendChild($this->_page_tools);
		return $this->__self;
	}
	
}