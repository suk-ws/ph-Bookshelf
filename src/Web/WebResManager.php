<?php

namespace SukWs\Bookshelf\Web;

use DOMDocument;
use DOMElement;
use SukWs\Bookshelf\Utils\Resources;
use SukWs\Bookshelf\Web\WebResource\JavascriptRaw;
use SukWs\Bookshelf\Web\WebResource\JavascriptRef;
use SukWs\Bookshelf\Web\WebResource\StylesheetsRef;

class WebResManager {
	
	public HtmlPage $root;
	
	/* @var StylesheetsRef[] */ public array $stylesheets;
	/* @var JavascriptRef|JavascriptRaw[] */ public array $javascript_preload;
	/* @var JavascriptRef|JavascriptRaw[] */ public array $javascript_lazyload;
	
	public function __construct() {
		$this->stylesheets = self::getBasicCssList();
		$this->javascript_preload = array();
		$this->javascript_lazyload = self::getBasicJsLazyloadList();
	}
	
	/** @return DOMElement[] */
	public function getStylesheetsDOM (DOMDocument $root): array {
		$return = array();
		foreach ($this->stylesheets as $item) {
			$return[] = $item->build($root);
		}
		return $return;
	}
	
	/** @return DOMElement[] */
	public function getJavascriptPreloadsDOM (DOMDocument $root): array {
		$return = array();
		foreach ($this->javascript_preload as $item) {
			$return[] = $item->build($root);
		}
		return $return;
	}
	
	/** @return DOMElement[] */
	public function getJavascriptLazyloadsDOM (DOMDocument $root): array {
		$return = array();
		foreach ($this->javascript_lazyload as $item) {
			$return[] = $item->build($root);
		}
		return $return;
	}
	
	/** @return StylesheetsRef[] */
	public static function getBasicCssList (): array {
		return array(
			new StylesheetsRef(Resources::webResPath('css', "main", 1)),
			new StylesheetsRef(Resources::webResPath('css', "bread-card-markdown", 1)),
			new StylesheetsRef(Resources::webResPath('css', "bread-card-markdown-footnote", 1)),
			new StylesheetsRef(Resources::webResPath('css', "bread-card-markdown-task-list", 1)),
			new StylesheetsRef(Resources::webResPath('css', "bread-card-markdown-heading-permalink", 1)),
			new StylesheetsRef(Resources::webResPath('css', "bread-card-markdown-compat-highlight-js", 1)),
		);
	}
	
	/** @return JavascriptRef[] */
	public static function getBasicJsLazyloadList (): array {
		return array(
			new JavascriptRef(Resources::webResPath('js', "lib/utils-touchscreen-event", 1)),
			new JavascriptRef(Resources::webResPath('js', "main", 1)),
		);
	}
	
}
