<?php

namespace SukWs\Bookshelf\Web\WebResource;

use DOMDocument;
use DOMElement;

abstract class IWebResource {
	
	public bool $enabled = true;
	
	abstract public function build (DOMDocument $root): DOMElement;
	
	public function toggleEnable (?bool $is = null): IWebResource {
		if ($is === null)
			$is = !$this->enabled;
		$this->enabled = $is;
		return $this;
	}
	
	public function isEnabled (): bool {
		return $this->enabled;
	}
	
}