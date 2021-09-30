<?php require_once "./src/Data/SiteMeta.php" ?>
		
		<!-- Gitbook Assets(js) -->
		<?php
		foreach (SiteMeta::getGitbookJavascriptList() as $item) {
			echo "<script src=\"$item\"></script>";
		}
		?>
		<script><?= SiteMeta::getCustomScriptContent("custom") ?></script>
		<script>
			bookCurrentId = "<?= PageMeta::$book->getId() ?>";
			pageCurrentId = "<?= PageMeta::$page->getId() ?>";
		</script>
		
	</body>
	
</html>
