<?php

namespace SukWs\Bookshelf\Web\WebResource;

use DOMDocument;
use DOMElement;
use SukWs\Bookshelf\Utils\Resources;
use SukWs\Bookshelf\Web\HtmlPage;

class WebResManager {
	
	public HtmlPage $root;
	
	/* @var StylesheetsRef[] */ public array $stylesheets;
	/* @var JavascriptRef|JavascriptRaw[] */ public array $javascript_preload;
	/* @var JavascriptRef|JavascriptRaw[] */ public array $javascript_lazyload;
	
	public readonly StylesheetHighlightjsTheme $_css_highlightjs;
	public readonly StylesheetsRef $_css_regex_highlight;
	public readonly StylesheetsRef $_css_ext_listing_rainbow;
	public readonly JavascriptRef $_js_highlightjs;
	public readonly JavascriptRef $_js_regex_highlight;
	public readonly JavascriptRef $_js_ext_rolling_title;
	public readonly JavascriptRef $_js_ext_title_permalink_flash;
	
	public function __construct() {
		
		$stylesheets = self::getBasicCssList();
		$javascript_preload = array();
		$javascript_lazyload = self::getBasicJsLazyloadList();
		
		$this->_css_highlightjs =
			(new StylesheetHighlightjsTheme("atom-one-dark"))
			->toggleEnable(true);
		$this->_js_highlightjs =
			(new JavascriptRef("//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/highlight.min.js"))
			->toggleEnable(true);
		$stylesheets[] = $this->_css_highlightjs;
		$javascript_lazyload[] = $this->_js_highlightjs;
		
		$this->_css_regex_highlight =
			(new StylesheetsRef("//cdn.jsdelivr.net/gh/suk-ws/regex-colorizer@master/regex-colorizer-default.min.css"))
			->toggleEnable(true);
		$this->_js_regex_highlight =
			(new JavascriptRef("//cdn.jsdelivr.net/gh/suk-ws/regex-colorizer@master/regex-colorizer.min.js"))
				->toggleEnable(true);
		$stylesheets[] = $this->_css_highlightjs;
		$javascript_lazyload[] = $this->_js_regex_highlight;
		
		$this->_css_ext_listing_rainbow =
			(new StylesheetsRef(Resources::webResPath('css', 'bread-card-markdown-enhanced-listing-rainbow', 1)))
			->toggleEnable(false);
		$stylesheets[] = $this->_css_ext_listing_rainbow;
		
		$this->_js_ext_rolling_title =
			(new JavascriptRef(Resources::webResPath('js', "enhanced-rolling-title", 1)))
			->toggleEnable(false);
		$javascript_lazyload[] = $this->_js_ext_rolling_title;
		
		$this->_js_ext_title_permalink_flash =
			(new JavascriptRef(Resources::webResPath('js', 'bread-card-markdown-heading-permalink-highlight', 1)))
			->toggleEnable(false);
		$this->javascript_lazyload[] = $this->_js_ext_title_permalink_flash;
		
		$this->stylesheets = $stylesheets;
		$this->javascript_preload = $javascript_preload;
		$this->javascript_lazyload = $javascript_lazyload;
		
	}
	
	/** @return DOMElement[] */
	public function build_stylesheetsDOM (DOMDocument $root): array {
		$return = array();
		foreach ($this->stylesheets as $item) {
			if ($item->enabled) $return[] = $item->build($root);
		}
		return $return;
	}
	
	/** @return DOMElement[] */
	public function build_javascriptPreloadsDOM (DOMDocument $root): array {
		$return = array();
		foreach ($this->javascript_preload as $item) {
			if ($item->enabled) $return[] = $item->build($root);
		}
		return $return;
	}
	
	/** @return DOMElement[] */
	public function build_javascriptLazyloadsDOM (DOMDocument $root): array {
		$return = array();
		foreach ($this->javascript_lazyload as $item) {
			if ($item->enabled) $return[] = $item->build($root);
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
