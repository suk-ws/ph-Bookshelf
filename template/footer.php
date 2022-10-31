<?php require_once "./src/Data/SiteMeta.php" ?>
<?php require_once "./src/Data/PageMeta.php" ?>
		
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
			<?php if (!(PageMeta::getConfigurationLevelPage("customization.article.codeblock.highlightjs")=="false")) :
			?>hljs.highlightAll();<?php endif; ?>
			<?php if (!(PageMeta::getConfigurationLevelPage("customization.article.regex.highlight")=="false")) :
			?>RegexColorizer.coloringAll();<?php endif; ?>
		</script>
		
	</body>
	
</html>
