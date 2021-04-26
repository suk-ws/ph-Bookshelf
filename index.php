<?php

require_once "./src/Data/SiteMeta.php";
require_once "./src/Data/PageMeta.php";

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
					<a href=".">Workshop Services</a>
				</h1>
			</div>
			<div class="page-wrapper" tabindex="-1" role="main">
				<div class="page-inner">
					<div id="book-search-results">
						<div class="search-noresults">
							<section class="normal markdown-section">
								<h1 id="workshop-services"><a name="workshop-services"
										class="anchor-navigation-ex-anchor" href="#workshop-services"><i
											class="fa fa-link" aria-hidden="true"></i></a>1. 占位主页面
								</h1>
								<p>歌德说过一句富有哲理的话，没有人事先了解自己到底有多大的力量，直到他试过以后才知道。这句话语虽然很短，但令我浮想联翩。 在这种困难的抉择下，本人思来想去，寝食难安。 经过上述讨论， 佚名说过一句富有哲理的话，感激每一个新的挑战，因为它会锻造你的意志和品格。这启发了我。</p>
								<p>我们都知道，只要有意义，那么就必须慎重考虑。 一般来讲，我们都必须务必慎重的考虑考虑。 本人也是经过了深思熟虑，在每个日日夜夜思考这个问题。 问题的关键究竟为何？ 带着这些问题，我们来审视一下占位内容。 就我个人来说，占位内容对我的意义，不能不说非常重大。</p>
								<p>鲁巴金曾经说过，读书是在别人思想的帮助下，建立起自己的思想。我希望诸位也能好好地体会这句话。</p>
								<font color="dark-yellow">既然如此， 占位内容因何而发生？ 经过上述讨论， 占位内容，发生了会如何，不发生又会如何。
									`喵~`
									我们一般认为，抓住了问题的关键，其他一切则会迎刃而解。
								</font>
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
