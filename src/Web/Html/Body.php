<?php

namespace SukWs\Bookshelf\Web\Html;

use DOMDocument;
use DOMElement;
use SukWs\Bookshelf\Web\Html\Sidebar\Sidebar;
use SukWs\Bookshelf\Web\HtmlPage;
use SukWs\Bookshelf\Web\WebWarn;

class Body {
	
	public HtmlPage $root;
	
	public DOMElement $__self;
	
	public Sidebar $_sidebar;
	
	public function __construct (HtmlPage $root) {
		
		$this->root = $root;
		$this->__self = $root->document->createElement("body");
		
		$this->_sidebar = new Sidebar($this);
		
	}
	
	public function build (): DOMElement {
		
		$this->__self->appendChild($this->_sidebar->build());
		
		foreach ($this->root->res_manager->getJavascriptLazyloadsDOM($this->root->document) as $script)
			$this->__self->appendChild($script);
		
		// output the warnings message at the end.
		$this->__self->appendChild(WebWarn::getWarningsAsJsLog()->build($this->root->document));
		
		return $this->__self;
		
	}
	
	private static function getMain (DOMDocument $root): DOMElement {
		
		/* @var */ $main = $root->createElement("main");
		$main->setAttribute("id", "main");
		
		/* @var */ $main_heading = $main->appendChild($root->createElement("div"));
		$main_heading->setAttribute("id", "main-heading");
		
		/* @var */ $page_tools = $main_heading->appendChild($root->createElement("div"));
		$page_tools->setAttribute("id", "page-tools");
		/* @var */ $tool_sidebar_show = $page_tools->appendChild($root->createElement("button", "☰"));
		$tool_sidebar_show->setAttribute("id", "sidebar-show");
		
		return $main;
		
	}
	
}
