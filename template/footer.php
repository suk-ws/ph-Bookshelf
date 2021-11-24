<?php require_once "./src/Data/SiteMeta.php" ?>
<?php require_once "./src/Data/PageMeta.php" ?>
		
		<!-- Assets(js) -->
		<?php
		foreach (SiteMeta::getJavascriptList() as $item) {
			if ($item==null) continue;
			echo "<script src=\"$item\"></script>";
		}
		?>
		<script><?= SiteMeta::getCustomScriptContent("custom") ?></script>
		<script>
			bookCurrentId = "<?= PageMeta::$book->getId() ?>";
			pageCurrentId = "<?= PageMeta::$page->getId() ?>";
			<?php if (!(PageMeta::getConfigurationLevelPage("customization.article.codeblock.highlightjs")=="false")) : ?>
			hljs.highlightAll();
			<?php endif; ?>
		</script>
		
	</body>
	
</html>
