<?php require_once "./src/Data/SiteMeta.php" ?>
<?php require_once "./src/Data/PageMeta.php" ?>
<div id="nav-container" class="prevent-animation"><nav id="sidebar">
		<noscript id="noscript-warn">For now, javascript must be enabled to view this site!!</noscript>
		<address id="site-title"><?= SiteMeta::getBookshelf()->getSiteName() ?></address>
		<div id="menu-container" class="menu-container sidebar-card">
			<div id="menu-metas" class="menu">
				<div class="menu-item-parent">
					<a class="no-style menu-item" href="javascript:">Links</a>
					<div class="children">
						<?= SiteMeta::getBookshelf()->getLinks()->getHtml() ?>
					</div>
				</div>
				<div class="menu-item-parent">
					<a class="no-style menu-item" href="javascript:">Books</a>
					<div class="children">
						<?= SiteMeta::getBookshelf()->getBooks()->getHtml() ?>
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
