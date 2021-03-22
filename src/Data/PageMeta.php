<?php

require_once "./src/Element/BookContent/BookContented.php";
require_once "./src/Element/BookContent/Page.php";

class PageMeta {
	
	public static BookContented $book;
	public static Page $page;
	public static bool $isMainPage;
	
	public static function getPageTitle (): string {
		return self::$page->getName()." - ".self::$book->getName();
	}
	
	public static function getDescription (): string {
		return ""; // todo wip description
	}
	
}
