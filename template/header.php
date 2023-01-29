<?php use SukWs\Bookshelf\Data\SiteConfig\ConfigName; ?>
<?php use SukWs\Bookshelf\Data\SiteMeta; ?>
<?php use SukWs\Bookshelf\Data\PageMeta; ?>
<!DOCTYPE HTML>
<html lang="<?= "" // TODO Page language ?>">
	<head>
		<!-- Static Meta -->
		<meta charset="UTF-8">
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta name="HandheldFriendly" content="true" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta name="generator" content="<?= SiteMeta::get_frontpage_generate_version() ?>">
		<!-- Page Meta -->
		<link rel="shortcut icon" href="<?= SiteMeta::getGlobalIcon() ?>">
		<title><?= PageMeta::getPageTitle() ?></title>
		<meta name="description" content="<?= PageMeta::getDescription() ?>">
		<!-- Assets(css) --><?php
		foreach (SiteMeta::getStylesheetsList() as $item) {
			if ($item==null) continue;
			echo "\n\t\t";
			echo "<link rel=\"stylesheet\" href=\"$item\">";
		}
		echo "\n";
		?>
		<!-- Customs(css) -->
		<style>
			:root {
				--bcm-color-codeblock-background: <?= PageMeta::getConfigurationLevelPage(ConfigName::codeblock_bg) ?>;
				--bcm-color-codeblock-foreground: <?= PageMeta::getConfigurationLevelPage(ConfigName::codeblock_fg) ?>;
			}
			pre code {
				tab-size: <?= PageMeta::getConfigurationLevelPage(ConfigName::codeblock_tab_size) ?>;
			}
		</style>
		<style><?= SiteMeta::getCustomCssContent("custom") ?></style>
	</head>
	<body>
