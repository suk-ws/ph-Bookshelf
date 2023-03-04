<?php

namespace SukWs\Bookshelf\Web\Html\Main;

use DOMElement;
use SukWs\Bookshelf\Web\Html\Body;
use SukWs\Bookshelf\Web\HtmlPage;

class MainContainer {
	
	public HtmlPage $root;
	public Body $parent;
	
	public DOMElement $__main;
	
	public DOMElement $_anchor_top;
	
	public Heading $_heading;
	
//	public DOMElement $_article;
	
	public function __construct (Body $parent) {
		
		$this->parent = $parent;
		$this->root = $parent->root;
		
		$this->__main = $this->root->document->createElement('main');
		$this->__main->setAttribute('id', 'main');
		
		$this->_anchor_top = $this->root->document->createElement('a');
		$this->_anchor_top->setAttribute('id', 'top');
		
		$this->_heading = new Heading($this);
		
	}
	
	public function build (): DOMElement {
		$this->__main->appendChild($this->_anchor_top);
		$this->__main->appendChild($this->_heading->build());
		return $this->__main;
	}
	
}