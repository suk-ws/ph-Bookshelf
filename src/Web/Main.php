<?php

namespace SukWs\Bookshelf\Web;
use SukWs\Bookshelf\Data\PageData;

class Main {
	
	public static function main (PageData $page): void {
		?>
		<main id="main">
			<div id="top"></div>
			<div id="main-heading">
				<div id="page-tools">
					<button id="sidebar-show">☰</button>
				</div>
			</div>
			<article id="article">
				<?php self::article($page); ?>
			</article>
		</main>
		<?php
	}
	
	public static function article (PageData $page): void {
		
		if ($page->gen_title) {
			?><h1><?= htmlentities($page->title) ?></h1><?php
		}
		
		echo $page->page_html;
		
	}
	
}