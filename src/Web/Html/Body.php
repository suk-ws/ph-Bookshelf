<?php

namespace SukWs\Bookshelf\Web\Html;

use DOMDocument;
use DOMElement;
use SukWs\Bookshelf\Web\Html\Main\MainContainer;
use SukWs\Bookshelf\Web\Html\Sidebar\Sidebar;
use SukWs\Bookshelf\Web\HtmlPage;
use SukWs\Bookshelf\Web\WebWarn;

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
	
	public function build (): DOMElement {
		
		$this->__self->appendChild($this->_sidebar->build());
		$this->__self->appendChild($this->_main->build());
		
		foreach ($this->root->res_manager->getJavascriptLazyloadsDOM($this->root->document) as $script)
			$this->__self->appendChild($script);
		
		// output the warnings message at the end.
		$this->__self->appendChild(WebWarn::getWarningsAsJsLog()->build($this->root->document));
		
		return $this->__self;
		
	}
	
}
