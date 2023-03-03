<?php

namespace SukWs\Bookshelf;

use SukWs\Bookshelf\Element\BookContent\BookContented;
use SukWs\Bookshelf\Element\BookContent\Page;
use SukWs\Bookshelf\SiteConfig\ConfigName;

class PageMeta {
	
	public static string $bookId;
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
		if (self::getConfigurationLevelPage(ConfigName::old_title_gen) == "true")
			return true;
		return false;
	}
	
	public static function highlightJsTheme (): string {
		$theme = trim(self::getConfigurationLevelPage(ConfigName::highlightjs_theme));
		if (empty($theme)) return "atom-one-dark";
		return $theme;
	}
	
	/**
	 * @return string[]
	 */
	public static function highlightJsLanguages (): array {
		$langDef = "";
		{
			$langDefList = array();
			$langDefList[] = SiteMeta::getConfigurationLevelShelf(ConfigName::highlightjs_lang);
			$langDefList[] = PageMeta::getConfigurationLevelBook(ConfigName::highlightjs_lang);
			$langDefList[] = PageMeta::getConfigurationLevelPage(ConfigName::highlightjs_lang);
			foreach ($langDefList as $langDefNode) $langDef .= $langDefNode . ";";
		}
		$lang = array();
		foreach (explode(";", $langDef) as $i) {
			$i = trim($i);
			if ($i != "") $lang[] =$i;
		}
		$lang = array_unique($lang);
		return $lang;
	}
	
}
