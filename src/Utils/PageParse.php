<?php

namespace SukWs\Bookshelf\Utils;

use SukWs\Bookshelf\Resource\Resource;

class PageParse {
	
	/**
	 * 按照原样输出资源文件
	 *
	 * @link https://segmentfault.com/a/1190000010912097
	 *
	 * @return bool 是否成功输出文件
	 */
	public static function outputBinaryFile (string $filePath): bool {
		
		// 获取文件名和文件后缀名
		$fileInfo = pathinfo($filePath);
		$filename = $fileInfo['basename'];
		$fileExtension = $fileInfo['extension'];
		// 将utf8编码转换成gbk编码，否则，中文名称的文件无法打开
		//		$filePath = iconv('UTF-8', 'gbk', $filePath);
		// 检查文件是否可读
		if (!is_file($filePath) || !is_readable($filePath)) {
			exit("File Can't Read!");
		}
		// 判定文件类型
		$fileMime = mime_content_type($filePath);
		$isText = false;
		if ($fileMime == "text/plain") {
			$isText = true;
			switch ($fileExtension) {
				case "css":
					$fileMime = "text/css";
					break;
				case "js":
					$fileMime = "application/javascript";
					break;
				default:
			}
		}
		// 文件类型是二进制流。设置为utf8编码（支持中文文件名称）
		header('Content-type:'.$fileMime.'; charset=utf-8');
		header("Access-Control-Allow-Origin: * ");
		if (isset($_GET['download'])) {
			// 触发浏览器文件下载功能
			header('Content-Disposition:attachment;filename="'.urlencode($filename).'"');
		}
		if ($isText) {
			echo file_get_contents($filePath);
		} else {
			// 二进制文件数据头
			header("Accept-Ranges: bytes");
			header("Content-Length: ".filesize($filePath));
			// 以只读方式打开文件，并强制使用二进制模式
			$fileHandle = fopen($filePath, "rb");
			if ($fileHandle === false) {
				exit("read false");
			}
			// 循环读取文件内容，并输出
			while (!feof($fileHandle)) {
				// 从文件指针 handle 读取最多 length 个字节（每次输出10k）
				echo fread($fileHandle, 10240);
			}
			// 关闭文件流
			fclose($fileHandle);
		}
		return true;
	}
	
	public static function output302 (string $url): void {
		header("Location: $url", true, 302);
		exit;
	}
	
	/**
	 * 根据链接数组生成对应的链接/路径
	 *
	 * eg.
	 * ["a2d", "WAE42WR6", "39272833"] => "a2d/WAE42WR6/39272833"
	 *
	 * @param string[] $uri
	 * @return string
	 */
	public static function genPathFromUriArray (array $uri): string {
		$result = "";
		foreach ($uri as $n) {
			$result .= $n . "/";
		}
		return substr($result, 0, -1);
	}
	
}
