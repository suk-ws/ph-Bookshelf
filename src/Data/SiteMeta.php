<?php

namespace SukWs\Bookshelf\Data;

use Exception;
use SukWs\Bookshelf\Data\SiteConfig\ConfigName;
use SukWs\Bookshelf\Data\SiteConfig\RobotsPolicy;
use SukWs\Bookshelf\Element\Bookshelf;

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
	public static function load (): void {
		self::$BOOKSHELF = Bookshelf::parseString(file_get_contents("./data/bookshelf.xml"));
	}
	
	public static function getBookshelf(): Bookshelf {
		return self::$BOOKSHELF;
	}
	
	public static function getGlobalIcon (): string {
		return "/favicon.ico"; // TODO ICON
	}
	
	public static function getStylesheetsList (): array {
		return array_merge(array(
//			"/assets/gitbook/style.css",
//			"/assets/gitbook/gitbook-plugin-fontsettings/website.css",
//			"/assets/gitbook-fix.css",
//			"/assets/ref.css",
			(PageMeta::getConfigurationLevelPage(ConfigName::prism)=="false"?
					null:"https://cdn.jsdelivr.net/gh/PrismJS/prism-themes@master/themes/".PageMeta::prismTheme().".min.css"),
			(PageMeta::getConfigurationLevelPage(ConfigName::regex_highlight)=="false")?
					null:"//cdn.jsdelivr.net/gh/suk-ws/regex-colorizer@master/regex-colorizer-default.min.css",
			"/assets/bread-card-markdown.css?ver=2",
			"/assets/bread-card-markdown-footnote.css?ver=1",
			"/assets/bread-card-markdown-task-list.css?ver=1",
			"/assets/bread-card-markdown-heading-permalink.css?ver=1",
			(PageMeta::getConfigurationLevelPage(ConfigName::ext_listing_rainbow)=="true"?
					"/assets/bread-card-markdown-enhanced-listing-rainbow.css?ver=1":null),
			"/assets/main.css?ver=1",
		),
		self::getPrismPluginsCss(PageMeta::prismPlugins())
		);
	}
	
	public static function getJavascriptList (): array {
		return array_merge(array(
//			"/assets/gitbook/gitbook.js",
//			"/assets/gitbook-fix.js",
//			"https://cdn.jsdelivr.net/npm/marked/marked.min.js",
//			"/assets/ref.js",
			(PageMeta::getConfigurationLevelPage(ConfigName::prism)=="false"?
				null:"//cdn.jsdelivr.net/npm/prismjs@v1.x/components/prism-core.min.js"),
			(PageMeta::getConfigurationLevelPage(ConfigName::prism)=="false"?
				null:"//cdn.jsdelivr.net/npm/prismjs@v1.x/plugins/autoloader/prism-autoloader.min.js"),
			(PageMeta::getConfigurationLevelPage(ConfigName::regex_highlight)=="false"?
					null:"//cdn.jsdelivr.net/gh/suk-ws/regex-colorizer@master/regex-colorizer.min.js"),
			(PageMeta::getConfigurationLevelPage(ConfigName::ext_rolling_title)=="true"?
					"/assets/enhanced-rolling-title.js?ver=1":null),
			(PageMeta::getConfigurationLevelPage(ConfigName::ext_title_permalink_flash)=="true"?
					"/assets/bread-card-markdown-heading-permalink-highlight.js?ver=1":null),
			"/assets/utils-touchscreen-event.js?ver=1",
			"/assets/main.js?ver=1",
		),
		self::getPrismPluginsJs(PageMeta::prismPlugins())
		);
	}
	
	public static function getCustomCssContent (string $id): string {
		if (!file_exists("./data/$id.css")) return "";
		return file_get_contents("./data/$id.css");
	}
	
	public static function getCustomScriptContent (string $id): string {
		if (!file_exists("./data/$id.js")) return "";
		return file_get_contents("./data/$id.js");
	}
	
	public static function getUserThemes (): string {
		$fontSize = $_COOKIE['font-size'] ?? 2;
		$fontFamily = $_COOKIE['font-family'] ?? 1;
		$colorTheme = $_COOKIE['color-theme'] ?? 0;
		return "font-size-$fontSize font-family-$fontFamily color-theme-$colorTheme";
	}
	
	public static function getConfigurationLevelShelf (string $key): ?string {
		return self::$BOOKSHELF->getConfiguration($key);
	}
	
	public static function getRobotsPolicy (): RobotsPolicy {
		return match (self::getConfigurationLevelShelf(ConfigName::robots_txt)) {
			"allow", null => RobotsPolicy::allow,
			"deny" => RobotsPolicy::deny,
			"custom", "file" => RobotsPolicy::file,
			default => RobotsPolicy::raw,
		};
	}
	
	public static function getPrismPluginsJs (array $plugins): array {
		$links = array();
		foreach ($plugins as $i) {
			$links[] = "//cdn.jsdelivr.net/npm/prismjs@v1.x/plugins/$i/prism-$i.min.js";
		}
		return $links;
	}
	
	public static function getPrismPluginsCss (array $plugins): array {
		$links = array();
		foreach ($plugins as $i) {
			$links[] = "//cdn.jsdelivr.net/npm/prismjs@v1.x/plugins/$i/prism-$i.min.css";
		}
		return $links;
	}
	
}
