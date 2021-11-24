<?php


require_once "./src/Data/SiteMeta.php";
require_once "./src/Data/PageMeta.php";
require_once "./src/Utils/PageParse.php";
require_once "./src/Utils/RequestNotExistException.php";



try {
	
	SiteMeta::load();
	
	// 格式化所给链接，并将链接转化为路径字符串数组
	$req = $_GET['p'];
	if (strlen($req) > 0 && $req[strlen($req) - 1] === '/')
		$tmp = substr($req, 0, -1);
	$uri = explode("/", $req, 2);
	
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
				PageMeta::$book = $tmp->getContentedNode();
			}
			
			// 判定当前页面
			if (sizeof($uri) > 1 && $uri[1] != null) {
				$tmp = PageMeta::$book->getPage($uri[1]);
				if ($tmp == null) throw new RequestNotExistException("Page required \"$uri[1]\" not found on book \"$uri[0]\"!");
				PageMeta::$page = $tmp;
			} else {
				PageMeta::$page = PageMeta::$book->getChilds()->getChilds()[0];
			}
		} else {
			// 主页面
			PageMeta::$book = SiteMeta::getBookshelf()->getRootBook();
			PageMeta::$page = PageMeta::$book->getChilds()->getChilds()[0];
			PageMeta::$isMainPage = true;
		}
		
	} catch (RequestNotExistException $e) {
		
		// 页面寻找失败，寻找资源文件
		
		if (!is_file($resLoc = "./data/%assets/$req")) { // 全局文件夹的资源文件
			throw $e;
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
