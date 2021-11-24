<?php

require_once "./src/Data/SiteMeta.php";
require_once "./src/Element/BookContent/BookContented.php";
require_once "./src/Element/BookContent/Page.php";

class PageMeta {
	
	public static BookContented $book;
	public static Page $page;
	public static bool $isMainPage = false;
	
	public static function getPageTitle (): string {
		return self::$page->getName()." - ".self::$book->getName();
	}
	
	public static function getDescription (): string {
		return ""; // todo wip description
	}
	
	public static function getConfigurationLevelBook (string $key): ?string {
		$value = SiteMeta::getConfigurationLevelShelf($key);
		$valueAttr = self::$book->getConfiguration($key);
		if ($valueAttr != null) $value = $valueAttr;
		return $value;
	}
	
	public static function getConfigurationLevelPage (string $key): ?string {
		$value = self::getConfigurationLevelBook($key);
		$valueAttr = self::$page->getConfiguration($key);
		if ($valueAttr != null) $value = $valueAttr;
		return $value;
	}
	
	public static function compatibilityOldTitlePolicy (): bool {
		if (self::getConfigurationLevelPage("compatibility.article.title.oldversion") == "true")
			return true;
		return false;
	}
	
	public static function highlightJsTheme (): string {
		$theme = trim(self::getConfigurationLevelPage("customization.article.codeblock.highlightjs.theme"));
		if (empty($theme)) return "atom-one-dark";
		return $theme;
	}
	
}
