<?php

namespace SukWs\Bookshelf\Web\WebResource;

class StylesheetHighlightjsTheme extends StylesheetsRef {
	
	public const PATH_BASE = "//cdnjs.cloudflare.com/ajax/libs/highlight.js/11.7.0/styles/{{theme}}.min.js";
	
	public string $theme;
	
	public function __construct (string $theme) {
		parent::__construct(self::themePath($theme));
		$this->theme = $theme;
	}
	
	public function setTheme (string $theme): StylesheetHighlightjsTheme {
		$this->uri = self::themePath($theme);
		$this->theme = $theme;
		return $this;
	}
	
	public static function themePath (string $theme): string {
		return str_replace("{{theme}}", $theme, self::PATH_BASE);
	}
	
}