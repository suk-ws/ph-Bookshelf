<?php

namespace SukWs\Bookshelf\Web\Html\Sidebar;

use DOMElement;
use SukWs\Bookshelf\Web\Html\Body;
use SukWs\Bookshelf\Web\HtmlPage;
use SukWs\Bookshelf\Web\WebWarn;

class Sidebar {
	
	public HtmlPage $root;
	
	public Body $parent;
	
	public DOMElement $_sidebar_container;
	public DOMElement $_sidebar;
	
	public DOMElement $_sidebar_site_title_node;
	public ?string $_sidebar_site_title_value;
	
	public bool $show_sidebar;
	
	public function __construct (Body $parent) {
		
		$this->parent = $parent;
		$this->root = $parent->root;
		
		$this->_sidebar_container = $this->root->document->createElement('div');
		$this->_sidebar_container->setAttribute('id', 'nav-container');
		
		$this->_sidebar = $this->root->document->createElement('nav');
		$this->_sidebar->setAttribute('id', 'sidebar');
		$this->show_sidebar = false;
		
		$this->_sidebar_site_title_node = $this->root->document->createElement('a');
		$this->_sidebar_site_title_node->setAttribute('id','site-title');
		$this->_sidebar_site_title_node->setAttribute('class', 'no-style');
		$this->_sidebar_site_title_node->setAttribute('href', "/");
		$this->_sidebar_site_title_value = null;
		
	}
	
	public function toggleSidebarShow (?bool $show = null): void {
		if ($show === null) $show = !$this->show_sidebar;
		$this->show_sidebar = $show;
	}
	
	public function setSiteTitle (string $title): void {
		$this->_sidebar_site_title_value = $title;
	}
	
	public function build (): DOMElement {
		
		if ($this->_sidebar_site_title_value == null) {
			$this->_sidebar_site_title_value = "...not set";
			WebWarn::output("[Web]<sidebar>: Site Title not set yet.");
		}
		$this->_sidebar_site_title_node->appendChild(
			$this->root->document->createTextNode($this->_sidebar_site_title_value));
		$this->_sidebar->appendChild($this->_sidebar_site_title_node);
		
		$this->_sidebar_container->appendChild($this->_sidebar);
		if ($this->show_sidebar)
			$this->_sidebar_container->setAttribute('class', 'show-sidebar');
		return $this->_sidebar_container;
		
	}
	
}