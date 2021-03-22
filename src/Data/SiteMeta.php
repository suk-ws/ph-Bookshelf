<?php

require_once "./src/Element/Bookshelf.php";

class SiteMeta {
	
	private static Bookshelf $BOOKSHELF;
	
	/**
	 * @throws Exception
	 */
	public static function load () {
		self::$BOOKSHELF = Bookshelf::parseString(file_get_contents("./data/bookshelf.xml"));
	}
	
	public static function getBookshelf(): Bookshelf {
		return self::$BOOKSHELF;
	}
	
	public static function getGlobalIcon (): string {
		return "/favicon.ico"; // TODO ICON
	}
	
	public static function getGitbookStylesheetsList (): array {
		return array(
			"gitbook/style.css",
			"gitbook/gitbook-plugin-highlight/website.css",
			"gitbook/gitbook-plugin-search/search.css",
			"gitbook/gitbook-plugin-fontsettings/website.css"
		);
	}
	
	public static function getGitbookJavascriptList (): array {
		return array(
			"gitbook/gitbook.js",
			"gitbook/theme.js",
			"gitbook/gitbook-plugin-search/search-engine.js",
			"gitbook/gitbook-plugin-search/search.js",
			"gitbook/gitbook-plugin-lunr/lunr.min.js",
			"gitbook/gitbook-plugin-lunr/search-lunr.js",
			"gitbook/gitbook-plugin-sharing/buttons.js",
			"gitbook/gitbook-plugin-fontsettings/fontsettings.js"
		);
	}
	
}
