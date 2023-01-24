<?php

namespace SukWs\Bookshelf\Utils;

use Erusev\Parsedown\Parsedown;

class ParsedownExtend extends Parsedown {
	
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
