<?php

require_once "./lib/Parsedown/Parsedown.php";
require_once "./lib/Parsedown/ParsedownExtra.php";

class ParsedownExtend extends ParsedownExtra {
	
	function __construct() {
		
		$this->InlineTypes['$'][] = 'RefMarkdown';
		
		$this->inlineMarkerList .= '$';
		
	}
	
	protected function inlineRefMarkdown ($excerpt) {
		if (preg_match('/^\$\(([\S ]*?)\)/', $excerpt['text'], $matches)) {
			return array(
				'extent' => strlen($matches[0]),
				'element' => array(
					'name' => 'ref',
					'text' => '',
					'attributes' => array(
						'source' => $matches[1],
					),
				),
			
			);
		}
	}
	
}
