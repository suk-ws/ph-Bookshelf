<?php

namespace SukWs\Bookshelf\Utils\Markdown;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;

class Parser {
	
	private static ?ConverterInterface $converter = null;
	
	public static function getDefaultParser (): ConverterInterface {
		
		// MarkDown Parser:
		// CommonMark
		$parserEnv = new Environment();
		$parserEnv->addExtension(new CommonMarkCoreExtension());
		
		// from GitHub Flavor Markdown
		// + autolink [https://link.to]
		// + strikethrough ~~removed~~
		// + table <table>
		// + task list [x]
		// - disallowed raw html <style><script>
		$parserEnv->addExtension(new AutolinkExtension());
		$parserEnv->addExtension(new StrikethroughExtension());
		$parserEnv->addExtension(new TableExtension());
		$parserEnv->addExtension(new TaskListExtension());
		
		// from Kramdown (PHP Markdown Extra?)
		// + html attributes {#title-1}
		$parserEnv->addExtension(new AttributesExtension());
		// from PHP Markdown Extra
		// + footnote [^1]
		// + description list <dl><dt><dd>
		$parserEnv->addExtension(new FootnoteExtension());
		$parserEnv->addExtension(new DescriptionListExtension());
		
		return new MarkdownConverter($parserEnv);
		
	}
	
	private static function getParser (): ConverterInterface {
		if (Parser::$converter === null)
			Parser::$converter = self::getDefaultParser();
		return Parser::$converter;
	}
	
	public static function parse (string $article): string {
		return self::getParser()->convert($article);
	}
	
}