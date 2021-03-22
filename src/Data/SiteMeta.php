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
			"/assets/gitbook/style.css",
			"/assets/gitbook/gitbook-plugin-expandable-chapters/expandable-chapters.css",
			"/assets/gitbook/gitbook-plugin-anchor-navigation-ex/style/plugin.css",
			"/assets/gitbook/gitbook-plugin-highlight/website.css",
			"/assets/gitbook/gitbook-plugin-search/search.css",
			"/assets/gitbook/gitbook-plugin-fontsettings/website.css"
		);
	}
	
	public static function getGitbookJavascriptList (): array {
		return array(
			"/assets/gitbook/gitbook.js",
			"/assets/gitbook/theme.js",
			"/assets/gitbook/gitbook-plugin-expandable-chapters/expandable-chapters.js",
			"/assets/gitbook/gitbook-plugin-search/search-engine.js",
			"/assets/gitbook/gitbook-plugin-search/search.js",
			"/assets/gitbook/gitbook-plugin-lunr/lunr.min.js",
			"/assets/gitbook/gitbook-plugin-lunr/search-lunr.js",
			"/assets/gitbook/gitbook-plugin-sharing/buttons.js",
			"/assets/gitbook/gitbook-plugin-fontsettings/fontsettings.js"
		);
	}
	
}
