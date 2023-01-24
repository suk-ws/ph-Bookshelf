<?php use SukWs\Bookshelf\Data\SiteMeta; ?>
<?php use SukWs\Bookshelf\Data\PageMeta; ?>
<div id="nav-container" class="prevent-animation"><nav id="sidebar">
		<noscript id="noscript-warn">For now, javascript must be enabled to view this site!!</noscript>
		<a id="site-title" class="no-style" href="/"><?= SiteMeta::getBookshelf()->getSiteName() ?></a>
		<div id="menu-container" class="menu-container sidebar-card">
			<div id="menu-metas" class="menu">
				<div class="menu-item-parent">
					<a class="no-style menu-item" href="javascript:">Links</a>
					<div class="children"><?=
						SiteMeta::getBookshelf()->getLinks()->getHtml(7) ?>
					</div>
				</div>
				<div class="menu-item-parent">
					<a class="no-style menu-item" href="javascript:">Books</a>
					<div class="children"><?=
						SiteMeta::getBookshelf()->getBooks()->getHtml(7) ?>
					</div>
				</div>
			</div>
			<div id="menu-pages" class="menu">
				<?= PageMeta::$book->getSummaryHtml() ?>
			</div>
			<div id="menu-about" class="menu">
<!--				<a class="no-style menu-item" href="https://sukazyo.cc" target="_blank">-->
<!--					<span>hosted by Sukazyo Workshop</span><br>-->
<!--					<small>&nbsp;| @author A.C.Sukazyo Eyre</small><br>-->
<!--					<small>&nbsp;<object><a class="no-style" href="https://laple.me/">| @author Lapis Apple</a></object></small><br>-->
<!--					<small>&nbsp;| @author github contributors&~&</small><br>-->
<!--					<small>&nbsp;| CC BY-NC-SA</small><br>-->
<!--					<small>&nbsp;| CC statement just for testing</small>-->
<!--				</a>-->
				<a class="no-style menu-item" href="https://github.com/suk-ws/ph-Bookshelf" target="_blank">
					<span>published with ph-Bookshelf</span><br>
					<small><?=SiteMeta::getProgramVersion()?></small><br>
					<small>with BreadCardUI</small>
				</a>
			</div>
		</div>
</nav></div>
