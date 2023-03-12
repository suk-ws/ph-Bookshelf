<?php

namespace SukWs\Bookshelf\Web;

use DOMElement;
use SukWs\Bookshelf\Web\WebResource\JavascriptRaw;

class WebLog {
	
	/** @var string[] $messages */
	private static array $messages = array();
	
	public static function info(string $message): void {
		self::log($message, "info");
	}
	
	public static function warn(string $message): void {
		self::log($message, "warn");
	}
	
	public static function error(string $message): void {
		self::log($message, "error");
	}
	
	public static function log (string $message, string $level): void {
		self::$messages[] = "[ph-Bookshelf][$level]>> $message";
	}
	
	/**
	 * Build a new "script" DOMElement that contains a list
	 * of `console.log` js code to output the warning messages.
	 *
	 * @return JavascriptRaw a fully new "script" object.
	 */
	public static function getWarningsAsJsLog (): JavascriptRaw {
		/* @var */ $js_log_code = "";
		foreach (self::$messages as $message) {
			$js_log_code .= "console.log(" . json_encode($message) .");";
		}
		return new JavascriptRaw($js_log_code);
	}
	
}