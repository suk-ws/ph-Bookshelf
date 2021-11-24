<?php

require_once "./src/Utils/ParsedownExtend.php";
require_once "./src/Data/PageMeta.php";

$parser = new ParsedownExtend();

$parser->setMarkupEscaped(false);
$parser->setSafeMode(false);

$pageMarkdownContent = PageMeta::$page->getMarkdownContent();

if (PageMeta::compatibilityOldTitlePolicy()) {
	$length = strlen($pageMarkdownContent);
	for ($i=0; $i<$length; $i++) {
		if (empty(trim($pageMarkdownContent[$i]))) {
			continue;
		} else if ($pageMarkdownContent[$i] == '#' && $pageMarkdownContent[$i+1] != '#') {
			break;
		}
		echo "<h1 id='phb-page-".PageMeta::$page->getId()."'>".PageMeta::$page->getName()."</h1>\n";
		break;
	}
}

echo $parser->text($pageMarkdownContent);
