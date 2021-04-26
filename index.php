<?php


require_once "./src/Data/SiteMeta.php";
require_once "./src/Data/PageMeta.php";
require_once "./lib/Parsedown/Parsedown.php";

$parser = new Parsedown();

$parser->setMarkupEscaped(false);
$parser->setSafeMode(false);

try {
	
	SiteMeta::load();
	
	// 格式化所给链接，并将链接转化为路径字符串数组
	$tmp = $_GET['p'];
	if (strlen($tmp) > 0 && $tmp[strlen($tmp) - 1] === '/')
		$tmp = substr($tmp, 0, -1);
	$uri = explode("/", $tmp, 2);
	
	if (sizeof($uri) > 0 && $uri[0] != null) {
		// 非主页面，判定当前定义的 book
		$tmp = SiteMeta::getBookshelf()->getBook($uri[0]);
		if ($tmp == null) throw new Exception("Book required \"$uri[0]\" not found!");
		PageMeta::$book = $tmp->getContentedNode();
		// 判定当前页面
		if (sizeof($uri) > 1 && $uri[1] != null) {
			$tmp = PageMeta::$book->getPage($uri[1]);
			if ($tmp == null) throw new Exception("Page required \"$uri[1]\" not found on book \"$uri[0]\"!");
			PageMeta::$page = $tmp;
		} else {
			PageMeta::$page = PageMeta::$book->getChilds()->getChilds()[0];
		}
	} else {
		// 主页面
		PageMeta::$book = SiteMeta::getBookshelf()->getRootBook();
		PageMeta::$page = PageMeta::$book->getChilds()->getChilds()[0];
		PageMeta::$isMainPage = true;
	}
	
	require "./template/header.php";
	
	?>
	
	<div class="book-summary">
		<div id="book-search-input">
			<ul id="site-name" class="summary">
				<li class="chapter active"><a><?= SiteMeta::getBookshelf()->getSiteName() ?></a></li>
			</ul>
		</div>
		<nav role="navigation">
			<?= SiteMeta::getBookshelf()->getHtml(); ?>
		</nav>
	</div>
	<div class="book-body">
		<div class="body-inner">
			<div class="book-header" role="navigation">
				<!-- Title -->
				<a class="btn pull-left js-toolbar-action" aria-label="" href="#" onclick="summaryOnOrOff()"><i class="fa fa-align-justify"></i></a>
				<div class="dropdown pull-left font-settings js-toolbar-action">
					<a class="btn toggle-dropdown" aria-label="Font Settings" href="#"><i class="fa fa-font"></i></a>
					<div class="dropdown-menu dropdown-right">
						<div class="dropdown-caret">
							<span class="caret-outer"></span>
							<span class="caret-inner"></span>
						</div>
						<div class="buttons">
							<button class="button size-2 font-reduce">A</button>
							<button class="button size-2 font-enlarge">A</button>
						</div>
						<div class="buttons">
							<button class="button size-2 ">Serif</button>
							<button class="button size-2 ">Sans</button>
						</div><div class="buttons">
							<button class="button size-3 ">White</button>
							<button class="button size-3 ">Sepia</button>
							<button class="button size-3 ">Night</button>
						</div>
					</div>
				</div>
				<h1>
					<i class="fa fa-circle-o-notch fa-spin"></i>
					<a href="."><?= PageMeta::$book->getName() ?></a>
				</h1>
			</div>
			<div class="page-wrapper" tabindex="-1" role="main">
				<div class="page-inner">
					<div id="book-search-results">
						<div class="search-noresults">
							<section class="normal markdown-section">
								<h1 id="workshop-services"><?= PageMeta::$page->getName() ?></h1>
								<?= $parser->text(PageMeta::$page->getMarkdownContent()) ?>
							</section>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	
	require "./template/footer.php";
	
} catch (Exception $e) {
	
	echo "<h1>ERROR</h1><p>" . $e->getMessage() . "</p>";
	
}