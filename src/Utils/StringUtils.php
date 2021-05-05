<?php

class StringUtils {
	
	/**
	 * 删除所给字符串的换行符
	 *
	 * @param string $str 所给字符串
	 *
	 * @return string 剔除换行符的版本
	 */
	public static function rmEOL(string $str): string {
		return str_replace(array("\r\n", "\r", "\n"), "", $str);
	}
	
}
