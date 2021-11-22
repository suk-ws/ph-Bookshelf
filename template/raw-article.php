<?php

require_once "./src/Utils/ParsedownExtend.php";
require_once "./src/Data/PageMeta.php";

$parser = new ParsedownExtend();

$parser->setMarkupEscaped(false);
$parser->setSafeMode(false);

echo "<h1 id='phb-page-".PageMeta::$page->getId()."'>".PageMeta::$page->getName()."</h1>\n";
echo $parser->text(PageMeta::$page->getMarkdownContent());
