<?php


require_once "./src/Data/SiteMeta.php";
require_once "./src/Data/PageMeta.php";
require_once "./src/Utils/ParsedownExtend.php";
require_once "./src/Utils/PageParse.php";
require_once "./src/Utils/RequestNotExistException.php";
require_once "./constant.php";

$parser = new ParsedownExtend();

$parser->setMarkupEscaped(false);
$parser->setSafeMode(false);

try {
	
	SiteMeta::load();
	
	// 检查是否为 ajax 请求
	$rawContent = $_GET['raw']=="true";
	$rawWithNav = $_GET['nav']=="true";
	
	// 格式化所给链接，并将链接转化为路径字符串数组
	$req = $_GET['p'];
	if (strlen($req) > 0 && $req[strlen($req) - 1] === '/')
		$tmp = substr($req, 0, -1);
	$uri = explode("/", $req, 2);
	
	try {
		
		// 寻找页面
		
		if (sizeof($uri) > 0 && $uri[0] != null) {
			// 非主页面，判定当前定义的 book
			$tmp = SiteMeta::getBookshelf()->getBook($uri[0]);
			if ($tmp == null) throw new RequestNotExistException("Book required \"$uri[0]\" not found!");
			PageMeta::$book = $tmp->getContentedNode();
			// 判定当前页面
			if (sizeof($uri) > 1 && $uri[1] != null) {
				$tmp = PageMeta::$book->getPage($uri[1]);
				if ($tmp == null) throw new RequestNotExistException("Page required \"$uri[1]\" not found on book \"$uri[0]\"!");
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
		
	} catch (RequestNotExistException $e) {
		
		// 页面寻找失败，寻找资源文件
		
		if (!is_file($resLoc = "./data/%assets/$req")) { // 全局文件夹的资源文件
//			if (!is_file($resLoc = sprintf("./data/%s/%s", PageParse::genPathFromUriArray($uri), $req))) { // 以当前页面为基准位置的资源文件
//				if (!is_file($resLoc = sprintf("./data/%s/%s", PageParse::genPathFromUriArray(array_slice($uri, 0, -1)), $req))) { // 以当前页面为基准位置的资源文件(fallback版)
//					if (!is_file($resLoc = sprintf("./data/%s/%s", PageMeta::$book->getId(), $req))) { // 以当前书籍为基准位置的资源文件
//						if (!is_file($resLoc = "./data/$req")) { // 全局的资源文件
			throw $e;
//						}
//					}
//				}
//			}
		}
		PageParse::outputBinaryFile($resLoc);
		
	}
	
	if ($rawContent && $rawWithNav) {
		echo PageMeta::$book->getSummaryHtml() . "\n";
	}
	
	if (!$rawContent) :
	
	require "./template/header.php";
	
	?>
	
	<div class="book-summary">
		<div id="book-search-input">
			<ul id="site-name" class="summary">
				<li class="chapter active"><a href="."><?= SiteMeta::getBookshelf()->getSiteName() ?></a></li>
			</ul>
		</div>
		<nav role="navigation">
			<ul id='global-container' class='summary'>
				<?= SiteMeta::getBookshelf()->getHtml(); ?>
				<li class='divider'></li>
				<li>
					<a href='https://github.com/Eyre-S/ph-Bookshelf' target='blank' class='gitbook-link'>
						Generated with ph-Bookshelf
						<br/><span class="annotation"><?= sprintf("%s at %s/%s", VERSION, CHANNEL, BRANCH) ?></span>
					</a>
				</li>
				<li>
					<a href='https://www.gitbook.com' target='blank' class='gitbook-link'>
						Front-End by GitBook
						<br/><span class="annotation"><?= GITBOOK_VERSION ?></span>
					</a>
				</li>
			</ul>
		</nav>
	</div>
	<div class="book-body">
		<div class="body-inner">
			<div class="book-header" role="navigation">
				<!-- Title -->
				<a class="btn pull-left js-toolbar-action" aria-label="" href="#" onclick="summaryOnOrOff()"><i class="fa fa-align-justify"></i></a>
				<div class="dropdown pull-left font-settings js-toolbar-action">
					<a class="btn toggle-dropdown" aria-label="Font Settings" onclick="openOrCloseFontSettings()"><i class="fa fa-font"></i></a>
					<div class="dropdown-menu dropdown-right">
						<div class="dropdown-caret">
							<span class="caret-outer"></span>
							<span class="caret-inner"></span>
						</div>
						<div class="buttons">
							<button class="button size-2 font-reduce" onclick="reduceFontSize()">A</button>
							<button class="button size-2 font-enlarge" onclick="enlargeFontSize()">A</button>
						</div>
						<div class="buttons">
							<button class="button size-2" onclick="setFontFamilySerif()">Serif</button>
							<button class="button size-2" onclick="setFontFamilySans()">Sans</button>
						</div><div class="buttons">
							<button class="button size-3" onclick="setColorThemeWhite()">White</button>
							<button class="button size-3" onclick="setColorThemeSepia()">Sepia</button>
							<button class="button size-3" onclick="setColorThemeNight()">Night</button>
						</div>
					</div>
				</div>
				<h1>
					<i class="fa fa-circle-o-notch fa-spin"></i>
					<a id="page-title"><?= PageMeta::$book->getName() ?></a>
				</h1>
			</div>
			<div class="page-wrapper" tabindex="-1" role="main">
				<div id="page-container" class="page-inner">
					<?php endif; ?>
					<div id="book-search-results">
						<div class="search-noresults">
							<section class="normal markdown-section">
								<h1 id="<?= PageMeta::$page->getId() ?>"><?= PageMeta::$page->getName() ?></h1>
								<?= $parser->text(PageMeta::$page->getMarkdownContent()) ?>
							</section>
						</div>
					</div>
					<?php if (!$rawContent) : ?>
				</div>
			</div>
		</div>
	</div>
	
	<?php
	
	require "./template/footer.php";
	
	endif;
	
} catch (Exception $e) {
	
	echo "<h1>ERROR</h1><p>" . $e->getMessage() . "</p>";
	
}
