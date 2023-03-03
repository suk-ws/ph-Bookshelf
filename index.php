<?php

require "./constant.php";
require "./vendor/autoload.php";

use SukWs\Bookshelf\PageMeta;
use SukWs\Bookshelf\SiteConfig\RobotsPolicy;
use SukWs\Bookshelf\SiteMeta;
use SukWs\Bookshelf\Utils\PageParse;
use SukWs\Bookshelf\Utils\RequestNotExistException;
use SukWs\Bookshelf\Web\HtmlPage;

$page = new HtmlPage();

echo $page->build()->document->saveHTML();

exit();

try {
	
	SiteMeta::load();
	
	// 格式化所给链接，并将链接转化为路径字符串数组
	$req = array_key_exists('p', $_GET) ? $_GET['p'] : "";
	if (strlen($req) > 0 && $req[strlen($req) - 1] === '/')
		$tmp = substr($req, 0, -1);
	$uri = explode("/", $req, 2);
	
	// 为 robots.txt 进行特别支持
	if (sizeof($uri) == 1 && $uri[0] == "robots.txt") {
		
		$policy = SiteMeta::getRobotsPolicy();
		
		switch ($policy) {
			case RobotsPolicy::allow:
				exit(file_get_contents("./assets/robots.allow"));
			case RobotsPolicy::deny:
				exit(file_get_contents("./assets/robots.deny"));
			case RobotsPolicy::file:
				exit(file_get_contents("./data/robots.txt"));
			case RobotsPolicy::raw:
				exit(SiteMeta::getConfigurationLevelShelf("site.robots"));
		}
		
	}
	
	try {
		
		// 寻找页面
		
		if (sizeof($uri) > 0 && $uri[0] != null) {
			// 非主页面，判定当前定义的 book
			if ($uri[0] == "%root") {
				PageMeta::$book = SiteMeta::getBookshelf()->getRootBook();
			} else {
				$tmp = SiteMeta::getBookshelf()->getBook($uri[0]);
				if ($tmp == null)
					throw new RequestNotExistException("Book required \"$uri[0]\" not found!");
				PageMeta::$bookId = $uri[0];
				PageMeta::$book = $tmp->getContentedNode();
			}
			
			// 判定当前页面
			if (sizeof($uri) > 1 && $uri[1] != null) {
				$tmp = PageMeta::$book->getPage($uri[1]);
				if ($tmp == null) throw new RequestNotExistException("Page required \"$uri[1]\" not found on book \"$uri[0]\"!");
				PageMeta::$page = $tmp;
			} else {
				PageMeta::$page = PageMeta::$book->getChildren()->getChildren()[0];
			}
		} else {
			// 主页面
			PageMeta::$bookId = "%root";
			PageMeta::$book = SiteMeta::getBookshelf()->getRootBook();
			PageMeta::$page = PageMeta::$book->getChildren()->getChildren()[0];
			PageMeta::$isMainPage = true;
		}
		
	} catch (RequestNotExistException $e) {
		
		// 页面寻找失败，寻找资源文件
		
		if ( // 搜索全局资源文件夹的指定文件
			file_exists($resLoc = "./data/%assets/$req")
		) {} else if ( // 搜索原始路径上的文件
			file_exists($resLoc = "./data/$req")
		) {} else if ( // 搜索可能存在的书籍资源文件夹中的指定文件
			sizeof($uri) > 1 && ($resBook = (SiteMeta::getBookshelf()->getBook($uri[0]))) != null &&
			file_exists($resLoc = "./data/{$resBook->getId()}/%assets/$uri[1]")
		) {} else if ( // 上面的 %root 兼容
			sizeof($uri) > 1 && ($resBook = $uri[0]) == "%root" &&
			file_exists($resLoc = "./data/$resBook/%assets/$uri[1]")
		) {} else if ( // 搜索以root书为根目录的原始路径上的文件
			file_exists($resLoc = "./data/%root/$req")
		) {} else if ( // 搜索root书中的书籍资源文件夹中的文件
			file_exists($resLoc = "./data/%root/%assets/$req")
		) {} else {
			throw $e; // 找不到资源文件
		}
		PageParse::outputBinaryFile($resLoc);
		
	}
	
	require "./template/header.php";
	
	require "./template/nav.php";
	
	require "./template/main.php";
	
	require "./template/footer.php";
	
} catch (Exception $e) {
	
	echo "<h1>ERROR</h1><p>" . $e->getMessage() . "</p>";
	
}



