<?php use SukWs\Bookshelf\Data\SiteConfig\ConfigName; ?>
<?php use SukWs\Bookshelf\Data\SiteMeta; ?>
<?php use SukWs\Bookshelf\Data\PageMeta; ?>
		
		<!-- Assets(js) --><?php
		foreach (SiteMeta::getJavascriptList() as $item) {
			if ($item==null) continue;
			echo "\n\t\t";
			echo "<script src=\"$item\"></script>";
		}
		echo "\n";
		?>
		<script><?= SiteMeta::getCustomScriptContent("custom") ?></script>
		<script>
			bookCurrentId = "<?= PageMeta::$book->getId() ?>";
			pageCurrentId = "<?= PageMeta::$page->getId() ?>";
			<?php if (!(PageMeta::getConfigurationLevelPage(ConfigName::highlightjs)=="false")) :
			?>hljs.highlightAll();<?php endif; ?>
			<?php if (!(PageMeta::getConfigurationLevelPage(ConfigName::regex_highlight)=="false")) :
			?>RegexColorizer.coloringAll();<?php endif; ?>
		</script>
		
	</body>
	
</html>
