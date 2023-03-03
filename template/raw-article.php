<?php

use SukWs\Bookshelf\PageMeta;
use SukWs\Bookshelf\Utils\HTML\HTML;
use SukWs\Bookshelf\Utils\LaTeX\LaTeX;
use SukWs\Bookshelf\Utils\Markdown\Markdown;
use SukWs\Bookshelf\Utils\ReST\ReST;

//   if the `compatibility.article.title.oldversion` is enabled
// that means the title should be auto-generated from book.xml
// but not written on page.md.
//   this code will generate a title from book.xml if the start
// of the page.md is not `# Title` formatting page title.
if (PageMeta::compatibilityOldTitlePolicy() && PageMeta::$page->hasContent(Markdown::type[0])) {
	$pageMarkdownContent = PageMeta::$page->getContent(Markdown::type[0]);
	$length = strlen($pageMarkdownContent);
	for ($i=0; $i<$length; $i++) {
		if (empty(trim($pageMarkdownContent[$i]))) {
			continue;
		} else if ($pageMarkdownContent[$i] == '#' && $pageMarkdownContent[$i+1] != '#') {
			break;
		}
		echo "<!-- compatibility old-title policy triggered -->\n";
		echo "<h1 id='phb-page-".PageMeta::$page->getId()."'>".PageMeta::$page->getName()."</h1>\n";
		break;
	}
}

$parsers = array(
	new HTML(),
	new Markdown(),
	new LaTeX(),
	new ReST()
);

$htmlContent = null;

foreach ($parsers as $parser) {
	$ok = false;
	foreach ($parser->type() as $suffix) {
		if (PageMeta::$page->hasContent($suffix)) {
			$htmlContent = $parser->parse(PageMeta::$page->getContent($suffix));
			$ok = true;
		}
	}
	if ($ok) break;
}

echo $htmlContent;
