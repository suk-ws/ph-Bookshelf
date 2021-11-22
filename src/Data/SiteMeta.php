<?php

require_once "./src/Element/Bookshelf.php";
require_once "./constant.php";

class SiteMeta {
	
	private static Bookshelf $BOOKSHELF;
	
	static function get_frontpage_generate_version (): string {
		return APP_NAME." ".VERSION;
	}
	
	public static function getProgramVersion(): string {
		return sprintf("%s @%s/%s", VERSION, CHANNEL, BRANCH);
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
//			"/assets/gitbook/style.css",
//			"/assets/gitbook/gitbook-plugin-fontsettings/website.css",
//			"/assets/gitbook-fix.css",
//			"/assets/ref.css",
			"/assets/main.css",
		);
	}
	
	public static function getGitbookJavascriptList (): array {
		return array(
//			"/assets/gitbook/gitbook.js",
//			"/assets/gitbook-fix.js",
//			"https://cdn.jsdelivr.net/npm/marked/marked.min.js",
//			"/assets/ref.js",
			"/assets/main.js",
		);
	}
	
	public static function getCustomCssContent (string $id): string {
		return file_get_contents("./data/$id.css");
	}
	
	public static function getCustomScriptContent (string $id): string {
		return file_get_contents("./data/$id.js");
	}
	
	public static function getUserThemes (): string {
		$fontSize = $_COOKIE['font-size'] ?? 2;
		$fontFamily = $_COOKIE['font-family'] ?? 1;
		$colorTheme = $_COOKIE['color-theme'] ?? 0;
		return "font-size-$fontSize font-family-$fontFamily color-theme-$colorTheme";
	}
	
}
