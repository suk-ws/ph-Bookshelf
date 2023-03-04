<?php

namespace SukWs\Bookshelf\Web\Html\Sidebar;

use DOMDocument;
use DOMElement;

class WebError {
	
	/* @var string[] */ public array $errorMessages = array();
	
	public function addErrorMessage(string $message): void {
		$this->errorMessages[] = $message;
	}
	
	/** @return DOMElement[] */
	public function getErrorsAsSidebarWarning(DOMDocument $root): array {
		$domList = array();
		foreach ($this->errorMessages as $error) {
			$dom = $root->createElement('div');
			$dom->setAttribute('class', 'warnings');
			$dom->appendChild($root->createTextNode($error));
			$domList[] = $dom;
		}
		return $domList;
	}
	
}