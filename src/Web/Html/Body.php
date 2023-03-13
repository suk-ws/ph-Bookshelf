<?php

namespace SukWs\Bookshelf\Web\Html;

use DOMDocument;
use DOMElement;
use SukWs\Bookshelf\Data\Bookshelf\NodeBookshelf;
use SukWs\Bookshelf\Web\Html\Main\MainContainer;
use SukWs\Bookshelf\Web\Html\Sidebar\Sidebar;
use SukWs\Bookshelf\Web\HtmlPage;
use SukWs\Bookshelf\Web\WebLog;

class Body {
	
	public HtmlPage $root;
	
	public DOMElement $__self;
	
	public Sidebar $_sidebar;
	public MainContainer $_main;
	
	public function __construct (HtmlPage $root) {
		
		$this->root = $root;
		$this->__self = $root->document->createElement("body");
		
		$this->_sidebar = new Sidebar($this);
		$this->_main = new MainContainer($this);
		
	}
	
	public function _parseBookshelf (NodeBookshelf $_data_shelf): void {
		$this->_sidebar->_parseBookshelf($_data_shelf);
	}
	
	public function build (): DOMElement {
		
		$this->__self->appendChild($this->_sidebar->build());
		$this->__self->appendChild($this->_main->build());
		
		foreach ($this->root->res_manager->build_javascriptLazyloadsDOM($this->root->document) as $script)
			$this->__self->appendChild($script);
		
		return $this->__self;
		
	}
	
}
