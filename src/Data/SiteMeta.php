<?php

require_once "./src/Element/Bookshelf.php";
require_once "./constant.php";

class SiteMeta {
	
	private static Bookshelf $BOOKSHELF;

	static function get_frontpage_generate_version (): string {
		return APP_NAME." ".VERSION." with Gitbook ".GITBOOK_VERSION;
	}
	
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
	
	public static function getCustomCssContent (string $id): string {
		return file_get_contents("./data/$id.css");
	}
	
	public static function getCustomScriptContent (string $id): string {
		return file_get_contents("./data/$id.js");
	}
	
}
