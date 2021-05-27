<?php require_once "./src/Data/SiteMeta.php" ?>
<?php require_once "./src/Data/PageMeta.php" ?>
<!DOCTYPE HTML>
<html lang="<?= "" // TODO Page language ?>">
	<head>
		<!-- Gitbook Meta -->
		<meta charset="UTF-8">
		<meta content="text/html; charset=utf-8" http-equiv="Content-Type">
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="HandheldFriendly" content="true" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<!-- Page Meta -->
		<link rel="shortcut icon" href="<?= SiteMeta::getGlobalIcon() ?>" type="image/x-icon">
		<!-- Unused: <link rel="apple-touch-icon-precomposed" sizes="152x152" href="gitbook/images/apple-touch-icon-precomposed-152.png"> -->
		<title><?= PageMeta::getPageTitle() ?></title>
		<meta name="description" content="<?= PageMeta::getDescription() ?>">
		<meta name="generator" content="<?= SiteMeta::get_frontpage_generate_version() ?>">
		<!-- Gitbook Assets(css) -->
		<?php
		foreach (SiteMeta::getGitbookStylesheetsList() as $item) {
			echo "<link rel=\"stylesheet\" href=\"$item\">";
		}
		?>
		<!-- Customs(css) -->
		<style><?= SiteMeta::getCustomCssContent("custom") ?></style>
	</head>
	<body>
		<div class="book <?= SiteMeta::getUserThemes() ?>">
		