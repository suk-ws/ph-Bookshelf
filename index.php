<?php

require "./config.php";
require "./constant.php";
require "./vendor/autoload.php";

use SukWs\Bookshelf\Data\PageMeta;
use SukWs\Bookshelf\Data\SiteConfig\RobotsPolicy;
use SukWs\Bookshelf\Data\SiteMeta;
use SukWs\Bookshelf\Resource\Assets;
use SukWs\Bookshelf\Resource\Data;
use SukWs\Bookshelf\Utils\PageParse;
use SukWs\Bookshelf\Web\Main;

try {
	
	SiteMeta::load();
	
	// 格式化所给链接，并将链接转化为路径字符串数组
	$req = substr(urldecode($_SERVER['REQUEST_URI']), 1);
	if (strlen($req) > 0 && $req[strlen($req) - 1] === '/')
		$tmp = substr($req, 0, -1);
	$uri = explode("/", $req, 2);
	
	// 为 robots.txt 进行特别支持
	if (sizeof($uri) == 1 && $uri[0] == "robots.txt") {
		
		$policy = SiteMeta::getRobotsPolicy();
		
		switch ($policy) {
			case RobotsPolicy::allow:
				exit(Assets::get("robots.allow")->get_content());
			case RobotsPolicy::deny:
				exit(Assets::get("robots.deny")->get_content());
			case RobotsPolicy::file:
				exit(Data::get("./data/robots.txt")->get_content());
			case RobotsPolicy::raw:
				exit(SiteMeta::getConfigurationLevelShelf("site.robots"));
		}
		
	} else if (PageMeta::init($uri)) {
		
		require "./template/header.php";
		
		require "./template/nav.php";
		
		Main::main(PageMeta::$page_data);
		
		require "./template/footer.php";
		
	} else {
		
		// 页面寻找失败，寻找资源文件
		
		if ( // 搜索全局资源文件夹的指定文件
			is_file($resLoc = "./data/%assets/$req")
		) {} else if ( // 搜索原始路径上的文件
			is_file($resLoc = "./data/$req")
		) {} else if ( // 搜索可能存在的书籍资源文件夹中的指定文件
			sizeof($uri) > 1 && ($resBook = (SiteMeta::getBookshelf()->getBook($uri[0]))) != null &&
			is_file($resLoc = "./data/{$resBook->getId()}/%assets/$uri[1]")
		) {} else if ( // 上面的 %root 兼容
			sizeof($uri) > 1 && ($resBook = $uri[0]) == "%root" &&
			is_file($resLoc = "./data/$resBook/%assets/$uri[1]")
		) {} else if ( // 搜索以root书为根目录的原始路径上的文件
			is_file($resLoc = "./data/%root/$req")
		) {} else if ( // 搜索root书中的书籍资源文件夹中的文件
			is_file($resLoc = "./data/%root/%assets/$req")
		) {} else {
			throw new Exception("cannot find file " . $req); // 找不到资源文件
		}
		PageParse::outputBinaryFile($resLoc);
		
	}
	
} catch (Exception $e) {
	
	echo "<h1>ERROR</h1><p>" . $e->getMessage() . "</p>";
	
}
