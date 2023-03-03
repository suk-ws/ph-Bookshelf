<?php

namespace SukWs\Bookshelf\Web;

use DOMElement;
use SukWs\Bookshelf\Web\WebResource\JavascriptRaw;

class WebWarn {
	
	/** @var string[] $warnings */
	private static array $warnings = array();
	
	public static function output(string $message): void {
		self::$warnings[] = $message;
	}
	
	/**
	 * Build a new "script" DOMElement that contains a list
	 * of `console.log` js code to output the warning messages.
	 *
	 * @return JavascriptRaw a fully new "script" object.
	 */
	public static function getWarningsAsJsLog (): JavascriptRaw {
		/* @var */ $js_log_code = "";
		foreach (self::$warnings as $message) {
			$message = str_replace("\"", "\\\"", $message);
			$message = "[ph-Bookshelf] " . $message;
			$js_log_code .= "console.log(\"$message\");\n";
		}
		return new JavascriptRaw($js_log_code);
	}
	
}