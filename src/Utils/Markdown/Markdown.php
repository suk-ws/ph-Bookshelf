<?php

namespace SukWs\Bookshelf\Utils\Markdown;

use League\CommonMark\ConverterInterface;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\DescriptionList\DescriptionListExtension;
use League\CommonMark\Extension\Footnote\FootnoteExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Strikethrough\StrikethroughExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use League\CommonMark\MarkdownConverter;
use SukWs\Bookshelf\Utils\PageContentType;

class Markdown implements PageContentType {
	
	private ?ConverterInterface $converter = null;
	public const type = array("md");
	
	/**
	 * @return string[]
	 */
	public function type (): array {
		return self::type;
	}
	
	public static function getDefaultParser (): ConverterInterface {
		
		$parserConfig = [
			'heading_permalink' => [
				'symbol' => "⁕",
				'insert' => 'after',
				'id_prefix' => "",
				'fragment_prefix' => "",
				'title' => ""
			]
		];
		
		// MarkDown Parser:
		// CommonMark
		$parserEnv = new Environment($parserConfig);
		$parserEnv->addExtension(new CommonMarkCoreExtension());
		
		// + heading(title) permalink # [title](#title)
		$parserEnv->addExtension(new HeadingPermalinkExtension());
		
		// + front matter --- title: Front Matter? ---
		$parserEnv->addExtension(new FrontMatterExtension());
		
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
	
	private function getParser (): ConverterInterface {
		if ($this->converter === null)
			$this->converter = self::getDefaultParser();
		return $this->converter;
	}
	
	public function parse (string $raw): string {
		return $this->getParser()->convert($raw);
	}
	
}