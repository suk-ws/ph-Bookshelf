<?php

namespace SukWs\Bookshelf\Web\Html\Sidebar;

use DOMElement;
use SukWs\Bookshelf\Data\Bookshelf\NodeBookshelf;
use SukWs\Bookshelf\Web\Html\Body;
use SukWs\Bookshelf\Web\HtmlPage;

class Sidebar {
	
	const WARNING_NOSCRIPT = "For now, javascript must be enabled to view this site!!";
	
	public HtmlPage $root;
	
	public Body $parent;
	
	public WebError $web_error;
	
	public DOMElement $_sidebar_container;
	public DOMElement $_sidebar;
	
	public DOMElement $_sidebar_site_title_node;
	public ?string $_sidebar_site_title_value;
	
	public DOMElement $_warning_noscript;
	
	public bool $show_sidebar;
	
	public function __construct (Body $parent) {
		
		$this->parent = $parent;
		$this->root = $parent->root;
		
		$this->web_error = new WebError();
		
		$this->_sidebar_container = $this->root->document->createElement('div');
		$this->_sidebar_container->setAttribute('id', 'nav-container');
		
		$this->_sidebar = $this->root->document->createElement('nav');
		$this->_sidebar->setAttribute('id', 'sidebar');
		$this->show_sidebar = true;
		
		$this->_warning_noscript = $this->root->document->createElement('noscript');
		$this->_warning_noscript->setAttribute('class', 'warnings');
		$this->_warning_noscript->appendChild($this->root->document->createTextNode(self::WARNING_NOSCRIPT));
		
		$this->_sidebar_site_title_node = $this->root->document->createElement('a');
		$this->_sidebar_site_title_node->setAttribute('id','site-title');
		$this->_sidebar_site_title_node->setAttribute('class', 'no-style');
		$this->_sidebar_site_title_node->setAttribute('href', "/");
		$this->_sidebar_site_title_value = null;
		
	}
	
	public function _parseBookshelf (NodeBookshelf $_data_shelf): void {
		$this->setSiteTitle($_data_shelf->_site_name);
	}
	
	public function toggleSidebarShow (?bool $show = null): void {
		if ($show === null) $show = !$this->show_sidebar;
		$this->show_sidebar = $show;
	}
	
	public function setSiteTitle (string $title): void {
		$this->_sidebar_site_title_value = $title;
	}
	
	public function build (): DOMElement {
		
		// === prebuild
		if ($this->_sidebar_site_title_value == null) {
			$this->_sidebar_site_title_value = "...";
			$this->web_error->addErrorMessage("Site Title not set.");
		}
		
		// === build
		
		// -- warning: overall
		foreach ($this->web_error->getErrorsAsSidebarWarning($this->root->document) as $error_dom) {
			$this->_sidebar->appendChild($error_dom);
		}
		// -- warning: noscript
		$this->_sidebar->appendChild($this->_warning_noscript);
		// -- site title
		$this->_sidebar_site_title_node->appendChild(
			$this->root->document->createTextNode($this->_sidebar_site_title_value));
		$this->_sidebar->appendChild($this->_sidebar_site_title_node);
		
		// == sidebar body
		$this->_sidebar_container->appendChild($this->_sidebar);
		if ($this->show_sidebar)
			$this->_sidebar_container->setAttribute('class', 'show-sidebar');
		return $this->_sidebar_container;
		
	}
	
}