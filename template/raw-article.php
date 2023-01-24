<?php

require_once "./src/Data/PageMeta.php";
require_once "./src/Utils/Markdown/Parser.php";

$pageMarkdownContent = PageMeta::$page->getMarkdownContent();

//   if the `compatibility.article.title.oldversion` is enabled
// that means the title should be auto-generated from book.xml
// but not written on page.md.
//   this code will generate a title from book.xml if the start
// of the page.md is not `# Title` formatting page title.
if (PageMeta::compatibilityOldTitlePolicy()) {
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

echo Parser::parse($pageMarkdownContent);
