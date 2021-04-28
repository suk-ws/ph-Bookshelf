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
			"/assets/gitbook-fix.css",
		);
	}
	
	public static function getGitbookJavascriptList (): array {
		return array(
			"/assets/gitbook/gitbook.js",
			"/assets/gitbook-fix.js",
		);
	}
	
}
